CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  reset_token VARCHAR(120) NULL,
  reset_expires DATETIME NULL,
  language VARCHAR(8) DEFAULT 'en',
  is_admin TINYINT(1) DEFAULT 0,
  created_at DATETIME NOT NULL
);

CREATE TABLE periods (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  start_date DATE NOT NULL,
  end_date DATE NOT NULL,
  notes TEXT NULL,
  created_at DATETIME NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE symptoms (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  period_id INT NOT NULL,
  symptom VARCHAR(50) NOT NULL,
  severity TINYINT NOT NULL DEFAULT 3,
  created_at DATETIME NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (period_id) REFERENCES periods(id) ON DELETE CASCADE
);

CREATE TABLE reminders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  type VARCHAR(40) NOT NULL,
  remind_at DATETIME NOT NULL,
  channel ENUM('email','dashboard','browser','sms','whatsapp') NOT NULL,
  enabled TINYINT(1) DEFAULT 1,
  created_at DATETIME NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE notifications (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  title VARCHAR(160) NOT NULL,
  body TEXT NOT NULL,
  is_read TINYINT(1) DEFAULT 0,
  created_at DATETIME NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE cycle_analysis (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  month_key CHAR(7) NOT NULL,
  avg_cycle_length TINYINT NOT NULL,
  avg_period_length TINYINT NOT NULL,
  irregularity_score DECIMAL(5,2) NOT NULL,
  ai_insight TEXT,
  created_at DATETIME NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE forum_posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  anonymous_name VARCHAR(80) NOT NULL,
  title VARCHAR(180) NOT NULL,
  body TEXT NOT NULL,
  is_hidden TINYINT(1) DEFAULT 0,
  created_at DATETIME NOT NULL
);
