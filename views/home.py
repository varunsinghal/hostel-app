# hostel-app/views/home.py

from flask import Blueprint, render_template, request

from models import Student

home = Blueprint('home', __name__)


@home.route('/')
def index():
    return render_template('home/index.html')


@home.route('/search')
def search():
    context = {'columns': Student.__table__.columns}
    column_name = request.args.get('column_name', default=None, type=str)
    query = '%' + request.args.get('query', default='', type=str) + '%'
    alloted = request.args.get('allotted', default=None, type=str)
    if column_name:
        if alloted:
            context['students'] = Student.query.filter(alloted=1).filter(
                getattr(Student, column_name).like(query)).all()
        else:
            context['students'] = Student.query.filter(getattr(Student, column_name).like(query)).all()
    return render_template('home/search.html', **context)
