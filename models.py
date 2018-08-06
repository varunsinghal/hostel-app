# hostel-app/models.py


from sqlalchemy import Column, String, Integer, Sequence, Float, ForeignKey
from sqlalchemy.orm import relationship

from app import db


class User(db.Model):
    __tablename__ = 'user'

    id = Column(Integer, Sequence('user_id_seq'), primary_key=True)
    username = Column(String(80), unique=True, nullable=False)
    email = Column(String(120), unique=True, nullable=False)
    password = Column(String(120))

    def __repr__(self):
        return '<User %r>' % self.username


class Room(db.Model):
    id = Column(Integer, Sequence('room_id_seq'), primary_key=True)
    hostel = Column(String(80), nullable=False)
    room_no = Column(String(80), nullable=False)
    capacity = Column(Integer, default=0)
    gender = Column(String(25))


class Student(db.Model):
    __tablename__ = 'student'

    id = Column(Integer, Sequence('student_id_seq'), primary_key=True)
    name = Column(String(80), nullable=False)

    # hostel details
    room_id = Column(Integer, ForeignKey('room.id'))
    current_room = relationship("Room", backref="student")
    last_room = Column(String(80))
    hostel_roll_no = Column(String(80))

    # personal details
    gender = Column(String(80), nullable=False)
    personal_phone = Column(String(80))
    email = Column(String(80))
    category_code = Column(String(80))
    school = Column(String(80))
    blood_group = Column(String(80))
    chronic = Column(String(80))

    # academic
    course = Column(String(80))
    roll_no = Column(String(80))
    branch = Column(String(80))
    semester = Column(Integer)
    year_of_admn = Column(Integer)
    backs = Column(Integer)

    # bank details
    bank_name = Column(String(80))
    bank_ifsc = Column(String(80))
    bank_acc = Column(String(80))
    bank_code = Column(String(80))
    bank_address = Column(String(80))
    bank_acc_name = Column(String(80))

    # father details
    father_name = Column(String(80))
    father_phone = Column(String(80))
    father_email = Column(String(80))
    father_occupation = Column(String(80))
    father_designation = Column(String(80))
    father_office_address = Column(String(80))
    father_office_phone = Column(String(80))

    # mother details
    mother_name = Column(String(80))
    mother_phone = Column(String(80))
    mother_email = Column(String(80))
    mother_occupation = Column(String(80))
    mother_designation = Column(String(80))
    mother_office_address = Column(String(80))
    mother_office_phone = Column(String(80))

    # residential address
    permanent_address = Column(String(80))
    permanent_city = Column(String(80))
    permanent_state = Column(String(80))
    permanent_country = Column(String(80))
    permanent_pin = Column(String(80))
    permanent_res_phone = Column(String(80))

    present_address = Column(String(80))
    present_city = Column(String(80))
    present_state = Column(String(80))
    present_country = Column(String(80))
    present_pin = Column(String(80))
    present_res_phone = Column(String(80))

    # local guardian
    lg_name = Column(String(80))
    lg_address = Column(String(80))
    lg_phone = Column(String(80))
    lg_occupation = Column(String(80))
    lg_office = Column(String(80))
    lg_office_phone = Column(String(80))

    # remark
    remark = Column(String(80))
    remark_datetime = Column(String(80))

    # variables
    form_no = Column(String(25))
    distance = Column(Float, default=0)
    document = Column(Integer, default=0)
    reallot = Column(Integer)

    def __repr__(self):
        return '<Student %r - %r>' % (self.id, self.name)


class Control(db.Model):
    id = Column(Integer, Sequence('user_id_seq'), primary_key=True)
    name = Column(String(80), unique=True, nullable=False)
    flag = Column(Integer, default=0)

    def __repr__(self):
        return '<Control %r - %r>' % (self.name, self.flag)
