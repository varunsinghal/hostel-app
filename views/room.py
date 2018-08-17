# views/room.py
from flask import Blueprint, render_template, request
from sqlalchemy import distinct

from app import db
from models import Room

room = Blueprint('room', __name__)


@room.route('/')
def index():
    context = {'hostels': db.session.query(distinct(Room.hostel).label('name'))}
    hostel_name = request.args.get('hostel', default=None, type=str)
    if hostel_name:
        rooms = db.session.query(Room.hostel, Room.room_no, Room.capacity, db.func.count(Room.students)) \
            .filter(Room.hostel == hostel_name).group_by(Room.hostel, Room.room_no, Room.capacity).all()
        context['rooms'] = rooms
    return render_template('room/index.html', **context)


@room.route('/add')
def add():
    pass


@room.route('/delete')
def delete():
    pass


@room.route('/edit')
def edit():
    pass


@room.route('/allot')
def allot():
    pass


@room.route('/deallot')
def deallot():
    pass
