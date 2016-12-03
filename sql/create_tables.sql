CREATE TABLE Usr(
  username varchar(20) PRIMARY KEY,
  password varchar(255) NOT NULL
);

CREATE TABLE Meme(
  id SERIAL PRIMARY KEY,
  poster varchar(20) REFERENCES Usr(username) ON DELETE CASCADE,
  title varchar(50) NOT NULL,
  type varchar(10) NOT NULL,
  content varchar(5000) NOT NULL
);

CREATE TABLE Favourite(
  username varchar(20) REFERENCES Usr(username) ON DELETE CASCADE,
  meme_id INTEGER REFERENCES Meme(id) ON DELETE CASCADE
);

CREATE TABLE Comment(
  id SERIAL PRIMARY KEY,
  poster varchar(20) REFERENCES Usr(username) ON DELETE CASCADE,
  parent_meme INTEGER REFERENCES Meme(id) ON DELETE CASCADE,
  message varchar(200) NOT NULL,
  posted timestamp NOT NULL,
  edited timestamp
);