CREATE TABLE Usr(
  id SERIAL PRIMARY KEY,
  name varchar(20) NOT NULL,
  password varchar(50) NOT NULL,
  is_admin boolean DEFAULT FALSE
);

CREATE TABLE Tag(
  id SERIAL PRIMARY KEY,
  poster INTEGER REFERENCES Usr(id),
  name varchar(20) NOT NULL,
  description varchar(200) NOT NULL
);

CREATE TABLE Meme(
  id SERIAL PRIMARY KEY,
  poster INTEGER REFERENCES Usr(id),
  title varchar(50) NOT NULL,
  type varchar(10) NOT NULL,
  content varchar(500) NOT NULL
);

CREATE TABLE MemeTags(
  tag_id INTEGER REFERENCES Tag(id),
  meme_id INTEGER REFERENCES Meme(id)
);

CREATE TABLE Comment(
  id SERIAL PRIMARY KEY,
  parent_meme INTEGER REFERENCES Meme(id),
  poster INTEGER REFERENCES Usr(id),
  message varchar(200) NOT NULL,
  posted timestamp NOT NULL,
  edited timestamp
);