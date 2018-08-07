# hostel-app/views/application.py
from flask import Blueprint, render_template, request
from sqlalchemy import distinct

from app import db
from models import Student

application = Blueprint('application', __name__)


@application.route('/')
def index():
    context = {'category_codes': db.session.query(distinct(Student.category_code).label('name')),
               'year_of_admns': db.session.query(distinct(Student.year_of_admn).label('name')),
               'courses': db.session.query(distinct(Student.course).label('name'))}
    if request.args:
        base_query = Student.query
        search_query = ''
        if request.args.get('category'):
            search_query += 'Category = ' + request.args.get('category') + ', '
            base_query = base_query.filter(Student.category_code == request.args.get('category'))
        if request.args.get('backs'):
            search_query += 'Backs = ' + request.args.get('backs') + ', '
            base_query = base_query.filter(Student.backs == request.args.get('backs'))
        if request.args.get('year_of_admn'):
            search_query += 'year of admission = ' + request.args.get('year_of_admn') + ', '
            base_query = base_query.filter(Student.year_of_admn == request.args.get('year_of_admn'))
        if request.args.get('gender'):
            search_query += 'Gender = ' + request.args.get('gender') + ', '
            base_query = base_query.filter(Student.gender == request.args.get('gender'))
        if request.args.get('course'):
            search_query += 'Course = ' + request.args.get('course') + ', '
            base_query = base_query.filter(Student.course == request.args.get('course'))
        if request.args.get('allotted') == 'allotted':
            search_query += 'Allotment status = ' + request.args.get('allotted') + ', '
            base_query = base_query.filter(Student.room_id.isnot(None))
        if request.args.get('allotted') == 'notallotted':
            search_query += 'Allotment status = Not allotted, '
            base_query = base_query.filter(Student.room_id is None)
        if request.args.get('reallot'):
            search_query += 'Re-allotment = ' + request.args.get('reallot') + ', '
            base_query = base_query.filter(Student.reallot == request.args.get('reallot'))
        if request.args.get('order') == 'distance':
            base_query = base_query.order_by(Student.distance.desc())
        if request.args.get('order') == 'name':
            base_query = base_query.order_by(Student.name.asc())
        if request.args.get('order') == 'timestamp':
            base_query = base_query.order_by(Student.created_on.asc())
        context['students'] = base_query.all()
        context['search_query'] = search_query
    return render_template('application/index.html', **context)


@application.route('/verified')
def verified():
    context = {'category_codes': db.session.query(distinct(Student.category_code).label('name')),
               'year_of_admns': db.session.query(distinct(Student.year_of_admn).label('name')),
               'courses': db.session.query(distinct(Student.course).label('name'))}
    if request.args:
        base_query = Student.query.filter(Student.document == 1)
        search_query = ''
        if request.args.get('category'):
            search_query += 'Category = ' + request.args.get('category') + ', '
            base_query = base_query.filter(Student.category_code == request.args.get('category'))
        if request.args.get('backs'):
            search_query += 'Backs = ' + request.args.get('backs') + ', '
            base_query = base_query.filter(Student.backs == request.args.get('backs'))
        if request.args.get('year_of_admn'):
            search_query += 'year of admission = ' + request.args.get('year_of_admn') + ', '
            base_query = base_query.filter(Student.year_of_admn == request.args.get('year_of_admn'))
        if request.args.get('gender'):
            search_query += 'Gender = ' + request.args.get('gender') + ', '
            base_query = base_query.filter(Student.gender == request.args.get('gender'))
        if request.args.get('course'):
            search_query += 'Course = ' + request.args.get('course') + ', '
            base_query = base_query.filter(Student.course == request.args.get('course'))
        if request.args.get('allotted') == 'allotted':
            search_query += 'Allotment status = ' + request.args.get('allotted') + ', '
            base_query = base_query.filter(Student.room_id.isnot(None))
        if request.args.get('allotted') == 'notallotted':
            search_query += 'Allotment status = Not allotted, '
            base_query = base_query.filter(Student.room_id is None)
        if request.args.get('reallot'):
            search_query += 'Re-allotment = ' + request.args.get('reallot') + ', '
            base_query = base_query.filter(Student.reallot == request.args.get('reallot'))
        if request.args.get('order') == 'distance':
            base_query = base_query.order_by(Student.distance.desc())
        if request.args.get('order') == 'name':
            base_query = base_query.order_by(Student.name.asc())
        if request.args.get('order') == 'timestamp':
            base_query = base_query.order_by(Student.created_on.asc())
        context['students'] = base_query.all()
        context['search_query'] = search_query
    return render_template('application/verified.html', **context)


@application.route('view')
def view():
    id = request.args.get('id')
    context = {'student': Student.query.get(id),
               'columns': Student.__table__.columns}
    return render_template('application/view.html', **context)


@application.route('edit', methods=['GET', 'POST'])
def edit():
    id = request.args.get('id')
    exclude_list = ['id', 'created_on', 'modified_on']
    context = {'student': Student.query.get(id),
               'columns': list(filter(lambda x: x.name not in exclude_list, Student.__table__.columns))}
    if request.form:
        for column in context['columns']:
            setattr(context['student'], column.name, request.form.get(column.name))
        db.session.commit()
    return render_template('application/edit.html', **context)


@application.route('/verify', methods=['POST'])
def verify():
    id = request.form.get('id')
    student = Student.query.get(id)
    student.document = 1
    db.session.commit()
    return 'Done successfully.'


@application.route('/unverify', methods=['POST'])
def unverify():
    id = request.form.get('id')
    student = Student.query.get(id)
    student.document = 0
    db.session.commit()
    return 'Done successfully.'
