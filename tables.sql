-- Tabelle für Benutzer
CREATE TABLE users
(
    id            INTEGER PRIMARY KEY AUTOINCREMENT,
    email         TEXT UNIQUE NOT NULL,
    password_hash TEXT        NOT NULL,
    created_at    DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at    DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE statuses
(
    id         INTEGER PRIMARY KEY AUTOINCREMENT,
    name       TEXT,
    priority   INTEGER,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
-- Tabelle für Aufgaben
CREATE TABLE tasks
(
    id               INTEGER PRIMARY KEY AUTOINCREMENT,
    title            TEXT    NOT NULL,
    status_id        INTEGER NOT NULL,
    due_date         DATETIME,
    priority         INTEGER,
    assigned_user_id INTEGER,
    created_at       DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at       DATETIME DEFAULT CURRENT_TIMESTAMP,
    completed_at     DATETIME,
    FOREIGN KEY (assigned_user_id) REFERENCES users (id),
    FOREIGN KEY (status_id) REFERENCES statuses (id)
);

-- Trigger für `updated_at` in der `tasks`-Tabelle
CREATE TRIGGER update_task_timestamp
    AFTER UPDATE
    ON tasks
    FOR EACH ROW
BEGIN
    UPDATE tasks
    SET updated_at = CURRENT_TIMESTAMP
    WHERE id = OLD.id;
END;

-- Trigger für `updated_at` in der `users`-Tabelle
CREATE TRIGGER update_user_timestamp
    AFTER UPDATE
    ON users
    FOR EACH ROW
BEGIN
    UPDATE users
    SET updated_at = CURRENT_TIMESTAMP
    WHERE id = OLD.id;
END;

-- Trigger für `updated_at` in der `statuses`-Tabelle
CREATE TRIGGER update_status_timestamp
    AFTER UPDATE
    ON statuses
    FOR EACH ROW
BEGIN
    UPDATE statuses
    SET updated_at = CURRENT_TIMESTAMP
    WHERE id = OLD.id;
END;