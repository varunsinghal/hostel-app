# hostel-app/views/public.py

from flask import Blueprint, render_template

public = Blueprint('public', __name__)


@public.route('/')
def index():
    return render_template('public/index.html')


@public.route('/authenticate')
def authenticate():
    return render_template('public/index.html')

# @app.route('/authenticate', methods=['POST'])
# def user_authenticate():
#     username = request.form.get('username')
#     password = request.form.get('password')
#     user = 1
#     if user:
#         return redirect(url_for('admin_index'))
#     return redirect(url_for('index', message='Message : Incorrect username/password combination'))
