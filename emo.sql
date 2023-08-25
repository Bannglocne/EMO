--     $servername = "localhost";
--     $username = "emo";
--     $password = "123456EmoR2";
--     $dbname = "emo";

-- Bảng "users":
CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(10) NOT NULL DEFAULT 'user',
    public VARCHAR(10) NOT NULL DEFAULT 'public',
    seen INT NOT NULL DEFAULT 0,
    report INT NOT NULL DEFAULT 0
);



-- Bảng "journals":
CREATE TABLE journals (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    content TEXT NOT NULL,
    emotion VARCHAR(6) NOT NULL,
    date VARCHAR(2) NOT NULL,
    month VARCHAR(2) NOT NULL,
    year VARCHAR(4) NOT NULL,
    public VARCHAR(10) NOT NULL DEFAULT 'private',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);



-- Bảng email
CREATE TABLE emails (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    sender_id INT(11) NOT NULL,
    receiver_id INT(11) NOT NULL,
    title VARCHAR(100) NOT NULL,
    content TEXT NOT NULL,
    reply_content TEXT,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES users(id),
    FOREIGN KEY (receiver_id) REFERENCES users(id)
);

-- Bảng letters
CREATE TABLE letters (
    so INT(11) AUTO_INCREMENT PRIMARY KEY,
    sogui INT(11) NOT NULL,
    sonhan INT(11) NOT NULL,
    tieude VARCHAR(100) NOT NULL,
    noidung TEXT NOT NULL,
    traloi TEXT,
    thoigian DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sogui) REFERENCES users(id),
    FOREIGN KEY (sonhan) REFERENCES users(id)
);

-- Bảng "users":
CREATE TABLE managers (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Bảng "news":
CREATE TABLE news (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    avatars VARCHAR(100) NOT NULL,
    title VARCHAR(100) NOT NULL,
    description VARCHAR(200) NOT NULL,
    content VARCHAR(10000) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    status TINYINT(3) DEFAULT '0'
)