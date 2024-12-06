CREATE TABLE applicant_information( 
    applicantID INT AUTO_INCREMENT PRIMARY KEY, 
    first_name VARCHAR (32), 
    last_name VARCHAR (32), 
    age INT, 
    gender VARCHAR (32), 
    email VARCHAR (64), 
    contact_info VARCHAR (64), 
    date_added DATETIME DEFAULT CURRENT_TIMESTAMP 
);

CREATE TABLE user_accounts (
	userID INT AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(255),
	first_name VARCHAR(255),
	last_name VARCHAR(255),
	user_password TEXT,
	date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
);

CREATE TABLE activity_logs (
	activity_log_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR (255),
	operation VARCHAR(255),
	applicantID INT,
	first_name VARCHAR (32),
    last_name VARCHAR (32),
    age INT,
    gender VARCHAR (32),
    email VARCHAR (64),
    contact_info VARCHAR (64),
    done_by INT,
    date_added DATETIME DEFAULT CURRENT_TIMESTAMP
);