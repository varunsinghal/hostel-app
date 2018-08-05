# hostel-app/views/public.py

from flask import Blueprint, render_template, request, url_for, session
from werkzeug.security import check_password_hash
from werkzeug.utils import redirect

from models import User

public = Blueprint('public', __name__)


@public.route('/')
def index():
    message = request.args.get('message', default='')
    return render_template('public/index.html', message=message)


@public.route('/authenticate', methods=['POST'])
def authenticate():
    username = request.form.get('username')
    password = request.form.get('password')
    user = User.query.filter_by(username=username).first()
    auth = check_password_hash(user.password, password)
    if auth:
        session['username'] = user.username
        return redirect(url_for('home.index'))
    return redirect(url_for('public.index', message='Message : Incorrect username/password combination'))


@public.route('/logout')
def logout():
    session.pop(session['username'])
    return redirect(url_for('public.index'))