from flask import Flask, url_for
from flask_sqlalchemy import SQLAlchemy
from werkzeug.utils import redirect

from views.home import home
from views.public import public

app = Flask(__name__)
app.config.from_pyfile('config.py')

db = SQLAlchemy(app)

app.register_blueprint(public, url_prefix='/public')
app.register_blueprint(home, url_prefix='/home')


@app.route("/")
def app_index():
    return redirect(url_for('public.index'))


if __name__ == '__main__':
    app.run()
