import mysql.connector
from random import shuffle

# Establish MySQL connection
def get_db_connection():
    try:
        conn = mysql.connector.connect(
            host='localhost',
            user='root',
            password='',
            database='automatic_tt'
        )
        if conn.is_connected():
            return conn
    except mysql.connector.Error as err:
        print(f"Error: {err}")
        return None

# Fetch Lecturers from the database
def fetch_lecturers(conn):
    lecturers = {}
    cursor = conn.cursor()
    try:
        cursor.execute("SELECT lec_id, lecturer_name FROM lecturers")
        rows = cursor.fetchall()
        for row in rows:
            lec_id, lecturer_name = row
            lecturers[lec_id] = {'lec_id': lec_id, 'lecturer_name': lecturer_name}
    except mysql.connector.Error as err:
        print(f"Error: {err}")
    finally:
        cursor.close()
    return lecturers

# Fetch Subjects from the database
def fetch_subjects(conn):
    subjects = []
    cursor = conn.cursor()
    try:
        cursor.execute("SELECT subject_id, subject_name, course_id, dep_id, lec_id FROM subjects")
        rows = cursor.fetchall()
        for row in rows:
            subject_id, subject_name, course_id, dep_id, lec_id = row
            subjects.append({
                'subject_id': subject_id,
                'subject_name': subject_name,
                'course_id': course_id,
                'dep_id': dep_id,
                'lec_id': lec_id  # No num_students field anymore
            })
    except mysql.connector.Error as err:
        print(f"Error: {err}")
    finally:
        cursor.close()
    return subjects

# Fetch Rooms from the database
def fetch_rooms(conn):
    rooms = {}
    cursor = conn.cursor()
    try:
        cursor.execute("SELECT room_id, room_name, capacity FROM rooms")
        rows = cursor.fetchall()
        for row in rows:
            room_id, room_name, capacity = row
            rooms[room_id] = {'room_id': room_id, 'room_name': room_name, 'capacity': capacity}
    except mysql.connector.Error as err:
        print(f"Error: {err}")
    finally:
        cursor.close()
    return rooms

# Fetch Time Slots from the database
def fetch_time_slots(conn):
    time_slots = []
    cursor = conn.cursor()
    try:
        cursor.execute("SELECT time_id, time_slot, start_time, end_time FROM time_slots")
        rows = cursor.fetchall()
        for row in rows:
            time_slots.append({'time_id': row[0], 'time_slot': row[1], 'start_time': row[2], 'end_time': row[3]})
    except mysql.connector.Error as err:
        print(f"Error: {err}")
    finally:
        cursor.close()
    return time_slots

# Save the generated timetable to the database
def save_timetable_to_db(timetable):
    try:
        conn = get_db_connection()
        if not conn:
            return
        cursor = conn.cursor()

        # Prepare SQL statement for inserting the timetable
        sql = """
        INSERT INTO timetable (dep_id, course_id, room_id, subject_id, lec_id, time_id, day_of_week)
        VALUES (%s, %s, %s, %s, %s, %s, %s)
        """
        
        # Iterate over the timetable and insert data into the database
        for entry in timetable:
            values = (
                entry['dep_id'],  # Department ID
                entry['course_id'],  # Course ID
                entry['room_id'],  # Room ID
                entry['subject_id'],  # Subject ID
                entry['lec_id'],  # Lecturer ID
                entry['time_id'],  # Time Slot ID
                entry['day_of_week']  # Day of the week
            )
            cursor.execute(sql, values)
        
        # Commit the transaction to save the changes to the database
        conn.commit()
        print("Timetable successfully saved to the database.")
    except mysql.connector.Error as err:
        print(f"Error: {err}")
    finally:
        if conn:
            conn.close()

# Helper function to check if the room is available
def is_room_available(room, time_slot, timetable):
    # Check if room is already booked at this time slot
    for entry in timetable:
        if entry['room_id'] == room['room_id'] and entry['time_id'] == time_slot['time_id']:
            return False  # Room is already booked
    return True

# Helper function to check if the lecturer is available
def is_lecturer_available(lecturer, time_slot, timetable):
    for entry in timetable:
        if entry['lec_id'] == lecturer['lec_id'] and entry['time_id'] == time_slot['time_id']:
            return False  # Lecturer is already booked for this time slot
    return True

# Scheduling function with updated availability checks
def schedule_timetable(lecturers, rooms, subjects, time_slots, days_of_week, current_subject_idx, timetable):
    if current_subject_idx >= len(subjects):
        return True  # All subjects assigned

    subject = subjects[current_subject_idx]
    lec_id = subject['lec_id']
    
    # Check if the lecturer exists in the dictionary
    if lec_id not in lecturers:
        print(f"Error: Lecturer with lec_id {lec_id} not found for subject {subject['subject_name']}")
        return False

    lecturer_name = lecturers[lec_id]['lecturer_name']
    
    # Shuffle the days and time slots once before iterating
    shuffle(days_of_week)
    
    for day in days_of_week:
        shuffle(time_slots)
        for time_slot in time_slots:
            for room_id, room in rooms.items():
                # Check if the room and lecturer are available
                if is_room_available(room, time_slot, timetable) and is_lecturer_available(lecturers[lec_id], time_slot, timetable):
                    timetable.append({
                        'subject_id': subject['subject_id'],
                        'subject_name': subject['subject_name'],
                        'course_id': subject['course_id'],
                        'lec_id': lec_id,
                        'lecturer_name': lecturer_name,
                        'room_id': room_id,
                        'room_name': room['room_name'],
                        'time_id': time_slot['time_id'],
                        'time_slot': time_slot['time_slot'],
                        'day_of_week': day,
                        'dep_id': subject['dep_id']  # Add department ID here
                    })
                    
                    # Recursively try to schedule the next subject
                    if schedule_timetable(lecturers, rooms, subjects, time_slots, days_of_week, current_subject_idx + 1, timetable):
                        return True
                    
                    # Backtrack if this scheduling doesn't work
                    timetable.pop()

    return False  # If no valid schedule found for this subject, return False

# Generate and print the timetable
def generate_timetable():
    conn = get_db_connection()

    if not conn:
        print("Failed to establish database connection!")
        return

    # Fetch all required data
    lecturers = fetch_lecturers(conn)
    rooms = fetch_rooms(conn)
    subjects = fetch_subjects(conn)
    time_slots = fetch_time_slots(conn)
    days_of_week = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']

    timetable = []
    success = schedule_timetable(lecturers, rooms, subjects, time_slots, days_of_week, 0, timetable)

    if success:
        print("Timetable successfully generated!")
        for entry in timetable:
            print(f"Subject: {entry['subject_name']}, Lecturer: {entry['lecturer_name']}, Room: {entry['room_name']}, "
                  f"Time: {entry['time_slot']} on {entry['day_of_week']}")
        
        # Save the generated timetable to the database
        save_timetable_to_db(timetable)
    else:
        print("Failed to generate a valid timetable!")

    conn.close()

if __name__ == "__main__":
    generate_timetable()
