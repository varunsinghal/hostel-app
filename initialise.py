# hostel-app/initialise.py

from werkzeug.security import generate_password_hash

from app import db
from models import User, Student, Control

db.create_all()

admin = User(username='admin', password=generate_password_hash('1234'), email='varunsinghal15@gmail.com')
db.session.add(admin)

# s1 = Student(name='trinity', gender='female', bank_name='abc bank')
# s2 = Student(name='john doe', gender='male', bank_name='bcd bank')
# s3 = Student(name='jane doe', gender='female', blood_group='B+')
# db.session.add(s1)
# db.session.add(s2)
# db.session.add(s3)

register = Control(name='Registration')
reallot = Control(name='Reallotment')
surrender = Control(name='Surrender')
db.session.add(register)
db.session.add(reallot)
db.session.add(surrender)

db.session.commit()
