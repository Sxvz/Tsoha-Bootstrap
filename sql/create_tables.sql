CREATE TABLE Usr(
  id SERIAL PRIMARY KEY,
  username varchar(20) UNIQUE NOT NULL,
  password varchar(50) NOT NULL
);

CREATE TABLE Meme(
  id SERIAL PRIMARY KEY,
  poster INTEGER REFERENCES Usr(id) ON DELETE CASCADE,
  title varchar(50) NOT NULL,
  type varchar(10) NOT NULL,
  content varchar(500) NOT NULL
);

CREATE TABLE Favourite(
  usr_id INTEGER REFERENCES Usr(id) ON DELETE CASCADE,
  meme_id INTEGER REFERENCES Meme(id) ON DELETE CASCADE
);

CREATE TABLE Comment(
  id SERIAL PRIMARY KEY,
  poster INTEGER REFERENCES Usr(id) ON DELETE CASCADE,
  parent_meme INTEGER REFERENCES Meme(id) ON DELETE CASCADE,
  message varchar(200) NOT NULL,
  posted timestamp NOT NULL,
  edited timestamp
);