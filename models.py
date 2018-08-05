# hostel-app/models.py


from sqlalchemy import Column, String, Integer, Sequence

from app import db


class User(db.Model):
    id = Column(Integer, Sequence('user_id_seq'), primary_key=True)
    username = Column(String(80), unique=True, nullable=False)
    email = Column(String(120), unique=True, nullable=False)
    password = Column(String(120))

    def __repr__(self):
        return '<User %r>' % self.username
