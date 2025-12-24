CREATE TABLE income (
    id INT PRIMARY KEY AUTO_INCREMENT,
    type VARCHAR(100),
    amount DECIMAL(10,2) NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    description TEXT
);

CREATE TABLE expense (
    id INT PRIMARY KEY AUTO_INCREMENT,
    type VARCHAR(100),
    amount DECIMAL(10,2) NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    description TEXT
);

INSERT INTO income (type, amount, date, description)
                    VALUES ('$type', '$amount', '$date', '$desc')

INSERT INTO expense (type, amount, date, description)
                    VALUES ('$type', '$amount', '$date', '$desc')

SELECT 'income' AS mode, id,type, amount, date, description
                        FROM income
                        UNION ALL
                        SELECT 'expense' AS mode, id,type, amount, date, description
                        FROM expense
                        ORDER BY id;

DELETE FROM $mode WHERE id = $id

UPDATE $mode SET type = ?, amount = ?, description = ?, date = ? WHERE id = ?