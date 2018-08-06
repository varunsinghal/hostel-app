from flask import Blueprint, render_template, url_for, request
from werkzeug.security import generate_password_hash
from werkzeug.utils import redirect

from app import db
from models import User

user = Blueprint('user', __name__)


@user.route('/')
def index():
    """ view all users """
    context = {'users': User.query.all()}
    return render_template('user/index.html', **context)


@user.route('/add', methods=['GET', 'POST'])
def add():
    context = {}
    if request.form:
        request.form['password'] = generate_password_hash(request.form.get('password'))
        new_user = User(**request.form.to_dict())
        db.session.add(new_user)
        db.session.commit()
        context['message'] = '&#9728; User has been added successfully.'
    return render_template('user/add.html', **context)


@user.route('/update', methods=['GET', 'POST'])
def update():
    context = {'user': User.query.filter_by(id=request.args.get('id')).first()}
    if request.form:
        to_update = context['user']
        to_update.username = request.form.get('username')
        to_update.password = generate_password_hash(request.form.get('password'))
        to_update.email = request.form.get('email')
        db.session.commit()
        context['message'] = '&#9728; User has been updated.'
    return render_template('user/update.html', **context)


@user.route('/delete')
def delete():
    user_id = request.args.get('id')
    user = User.query.get(user_id)
    db.session.delete(user)
    db.session.commit()
    message = '&#9728; User has been deleted.'
    return redirect(url_for('user.index', message=message))
