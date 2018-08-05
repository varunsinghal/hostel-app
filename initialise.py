# hostel-app/initialise.py

from werkzeug.security import generate_password_hash

from app import db
from models import User

db.create_all()

admin = User(username='admin', password=generate_password_hash('1234'), email='varunsinghal15@gmail.com')
db.session.add(admin)
db.session.commit()