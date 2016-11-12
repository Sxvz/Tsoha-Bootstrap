--Usr taulun testidata
INSERT INTO Usr (username, password) VALUES ('User', 'User');
INSERT INTO Usr (username, password) VALUES ('User2', 'User2');
--Meme taulun testidata
INSERT INTO Meme (poster, title, type, content) VALUES ('1', 'Homer into the bushes', 'Image', 'https://fat.gfycat.com/OptimalThoseFoal.gif');
INSERT INTO Meme (poster, title, type, content) VALUES ('1', 'Lenny Face', 'Copypasta', '( ͡° ͜ʖ ͡°)');
INSERT INTO Meme (poster, title, type, content) VALUES ('1', 'Aziz The Combat Fighter theme song', 'Video', 'WJc7S_UOfl4');
INSERT INTO Meme (poster, title, type, content) VALUES ('2', ':3', 'Copypasta', '(づ｡◕‿‿◕｡)づ');
INSERT INTO Meme (poster, title, type, content) VALUES ('2', 'Table flip', 'Copypasta', '(ノಠ益ಠ)ノ彡┻━┻');
INSERT INTO Meme (poster, title, type, content) VALUES ('2', 'Anti-table flip', 'Copypasta', '┬──┬ ノ( ゜-゜ノ)');
INSERT INTO Meme (poster, title, type, content) VALUES ('2', 'Why not Zoidberg?', 'Copypasta', 'Why not Zoidberg? (/) (°,,°) (/)');
INSERT INTO Meme (poster, title, type, content) VALUES ('2', 'One does not simply explain memes to someone', 'Image', 'http://s2.quickmeme.com/img/98/98b80beaf6a3449cc2410730d33d2ce863814382b83fab21193d119a9168d95e.jpg');
INSERT INTO Meme (poster, title, type, content) VALUES ('2', 'When you are no longer the frog', 'Image', 'http://gag.fm/uploads/posts/t/l-6632.jpg');
INSERT INTO Meme (poster, title, type, content) VALUES ('2', 'Why not both?', 'Image', 'https://i.kinja-img.com/gawker-media/image/upload/s--sXmOrBZL--/c_fit,fl_progressive,q_80,w_636/1238895886504840879.jpg');
INSERT INTO Meme (poster, title, type, content) VALUES ('1', 'The wrong dongerhood', 'Copypasta', '༼ ºل͟º༼ ºل͟º༼ ºل͟º ༽ºل͟º ༽ºل͟º ༽ YOU CAME TO THE WRONG DONGERHOOD༼ ºل͟º༼ ºل͟º༼ ºل͟º ༽ºل͟º ༽ºل͟º ༽');
--Favourite taulun testidata
INSERT INTO Favourite (usr_id, meme_id) VALUES ('1', '2');
INSERT INTO Favourite (usr_id, meme_id) VALUES ('1', '3');
INSERT INTO Favourite (usr_id, meme_id) VALUES ('2', '4');
INSERT INTO Favourite (usr_id, meme_id) VALUES ('2', '7');
--Comment taulun testidata
INSERT INTO Comment (poster, parent_meme, message, posted, edited) VALUES ('1', '1', 'Hello comment world!', 'now', 'now');
INSERT INTO Comment (poster, parent_meme, message, posted, edited) VALUES ('2', '1', 'Nice me.me', 'now', 'now');