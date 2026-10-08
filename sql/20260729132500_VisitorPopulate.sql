-- Populating fake data into the Visitor Table

-- cqu
INSERT INTO olivisit.visitors (
    organisation_id, 
    first_name,
    last_name,
    phone_number,
    email,
    start_time,
    end_time,
    created,
    modified
)
VALUES (
    '1',
    'Emma',
    'Watson',
    '0412345678',
    'emma.watson@gmail.com',
    '2026-07-28 09:15:00',
    '2026-07-28 11:45:00',
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
);

INSERT INTO olivisit.visitors (
    organisation_id, 
    first_name,
    last_name,
    phone_number,
    email,
    start_time,
    end_time,
    created,
    modified
)
VALUES (
    '1',
    'Liam',
    'Parker',
    '0412345679',
    'liam.parker@gmail.com',
    '2026-07-28 13:30:00',
    '2026-07-28 15:00:00',
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
);

INSERT INTO olivisit.visitors (
    organisation_id, 
    first_name,
    last_name,
    phone_number,
    email,
    start_time,
    end_time,
    created,
    modified
)
VALUES (
    '1',
    'Sophie',
    'Brown',
    '0412345680',
    'sophie.brown@gmail.com',
    '2026-07-29 08:45:00',
    '2026-07-29 10:15:00',
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
);

-- woolworths
INSERT INTO olivisit.visitors (
    organisation_id, 
    first_name,
    last_name,
    phone_number,
    email,
    start_time,
    end_time,
    created,
    modified
)
VALUES (
    '2',
    'Noah',
    'Smith',
    '0412345681',
    'noah.smith@gmail.com',
    '2026-07-29 10:00:00',
    '2026-07-29 12:30:00',
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
);

INSERT INTO olivisit.visitors (
    organisation_id, 
    first_name,
    last_name,
    phone_number,
    email,
    start_time,
    end_time,
    created,
    modified
)
VALUES (
    '2',
    'Chloe',
    'Davis',
    '0412345682',
    'chloe.davis@gmail.com',
    '2026-07-29 14:15:00',
    '2026-07-29 16:00:00',
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
);

-- aldi au
INSERT INTO olivisit.visitors (
    organisation_id, 
    first_name,
    last_name,
    phone_number,
    email,
    start_time,
    end_time,
    created,
    modified
)
VALUES (
    '3',
    'Jack',
    'Wilson',
    '0412345683',
    'jack.wilson@gmail.com',
    '2026-07-28 09:00:00',
    '2026-07-28 10:30:00',
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
);

INSERT INTO olivisit.visitors (
    organisation_id, 
    first_name,
    last_name,
    phone_number,
    email,
    start_time,
    end_time,
    created,
    modified
)
VALUES (
    '3',
    'Olivia',
    'Taylor',
    '0412345684',
    'olivia.taylor@gmail.com',
    '2026-07-28 11:00:00',
    '2026-07-28 13:15:00',
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
);

INSERT INTO olivisit.visitors (
    organisation_id, 
    first_name,
    last_name,
    phone_number,
    email,
    start_time,
    end_time,
    created,
    modified
)
VALUES (
    '3',
    'Ethan',
    'Miller',
    '0412345685',
    'ethan.miller@gmail.com',
    '2026-07-29 15:30:00',
    '2026-07-29 17:00:00',
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
);

-- aldi uk
INSERT INTO olivisit.visitors (
    organisation_id, 
    first_name,
    last_name,
    phone_number,
    email,
    start_time,
    end_time,
    created,
    modified
)
VALUES (
    '4',
    'George',
    'Thompson',
    '0712345678',
    'george.thompson@outlook.com',
    '2026-07-29 09:45:00',
    '2026-07-29 12:15:00',
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
);

INSERT INTO olivisit.visitors (
    organisation_id, 
    first_name,
    last_name,
    phone_number,
    email,
    start_time,
    end_time,
    created,
    modified
)
VALUES (
    '4',
    'Charlotte',
    'Evans',
    '0723456789',
    'charlotte.evans@gmail.com',
    '2026-07-29 13:00:00',
    '2026-07-29 15:45:00',
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
);

-- more
-- CQUniversity (organisation_id = 1)

INSERT INTO olivisit.visitors (
    organisation_id, first_name, last_name, phone_number, email,
    start_time, end_time, created, modified
)
VALUES (
    '1', 'Mia', 'Johnson', '0412345686', 'mia.johnson@gmail.com',
    '2026-08-01 09:00:00', '2026-08-01 10:30:00',
    CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
);

INSERT INTO olivisit.visitors (
    organisation_id, first_name, last_name, phone_number, email,
    start_time, end_time, created, modified
)
VALUES (
    '1', 'Benjamin', 'White', '0412345687', 'benjamin.white@gmail.com',
    '2026-08-01 11:00:00', '2026-08-01 13:00:00',
    CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
);

-- Woolworths (organisation_id = 2)

INSERT INTO olivisit.visitors (
    organisation_id, first_name, last_name, phone_number, email,
    start_time, end_time, created, modified
)
VALUES (
    '2', 'Grace', 'Martin', '0412345688', 'grace.martin@gmail.com',
    '2026-08-01 08:45:00', '2026-08-01 11:15:00',
    CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
);

INSERT INTO olivisit.visitors (
    organisation_id, first_name, last_name, phone_number, email,
    start_time, end_time, created, modified
)
VALUES (
    '2', 'William', 'Anderson', '0412345689', 'william.anderson@gmail.com',
    '2026-08-01 14:00:00', '2026-08-01 16:00:00',
    CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
);

-- Aldi AU (organisation_id = 3)

INSERT INTO olivisit.visitors (
    organisation_id, first_name, last_name, phone_number, email,
    start_time, end_time, created, modified
)
VALUES (
    '3', 'Ella', 'Moore', '0412345690', 'ella.moore@gmail.com',
    '2026-08-02 09:15:00', '2026-08-02 11:45:00',
    CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
);

INSERT INTO olivisit.visitors (
    organisation_id, first_name, last_name, phone_number, email,
    start_time, end_time, created, modified
)
VALUES (
    '3', 'James', 'Clark', '0412345691', 'james.clark@gmail.com',
    '2026-08-02 13:00:00', '2026-08-02 15:30:00',
    CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
);

-- Aldi UK (organisation_id = 4)

INSERT INTO olivisit.visitors (
    organisation_id, first_name, last_name, phone_number, email,
    start_time, end_time, created, modified
)
VALUES (
    '4', 'Oliver', 'Baker', '0767890123', 'oliver.baker@outlook.com',
    '2026-08-02 10:00:00', '2026-08-02 12:00:00',
    CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
);

INSERT INTO olivisit.visitors (
    organisation_id, first_name, last_name, phone_number, email,
    start_time, end_time, created, modified
)
VALUES (
    '4', 'Sophia', 'Turner', '0778901234', 'sophia.turner@gmail.com',
    '2026-08-02 14:15:00', '2026-08-02 16:45:00',
    CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
);

-- even more
-- CQUniversity (organisation_id = 1)
-- Historical visitors across multiple years

INSERT INTO olivisit.visitors (
    organisation_id, first_name, last_name, phone_number, email,
    start_time, end_time, created, modified
)
VALUES (
    '1', 'Nathan', 'Collins', '0412345692', 'nathan.collins@gmail.com',
    '2023-03-15 09:00:00', '2023-03-15 10:30:00',
    CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
);

INSERT INTO olivisit.visitors (
    organisation_id, first_name, last_name, phone_number, email,
    start_time, end_time, created, modified
)
VALUES (
    '1', 'Zoe', 'Mitchell', '0412345693', 'zoe.mitchell@gmail.com',
    '2023-07-12 13:15:00', '2023-07-12 15:00:00',
    CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
);

INSERT INTO olivisit.visitors (
    organisation_id, first_name, last_name, phone_number, email,
    start_time, end_time, created, modified
)
VALUES (
    '1', 'Aiden', 'Cooper', '0412345694', 'aiden.cooper@gmail.com',
    '2023-11-20 10:00:00', '2023-11-20 12:15:00',
    CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
);

INSERT INTO olivisit.visitors (
    organisation_id, first_name, last_name, phone_number, email,
    start_time, end_time, created, modified
)
VALUES (
    '1', 'Lily', 'Edwards', '0412345695', 'lily.edwards@gmail.com',
    '2024-01-18 08:30:00', '2024-01-18 10:00:00',
    CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
);

INSERT INTO olivisit.visitors (
    organisation_id, first_name, last_name, phone_number, email,
    start_time, end_time, created, modified
)
VALUES (
    '1', 'Isaac', 'Ward', '0412345696', 'isaac.ward@gmail.com',
    '2024-04-08 14:00:00', '2024-04-08 16:15:00',
    CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
);

INSERT INTO olivisit.visitors (
    organisation_id, first_name, last_name, phone_number, email,
    start_time, end_time, created, modified
)
VALUES (
    '1', 'Ruby', 'Stewart', '0412345697', 'ruby.stewart@gmail.com',
    '2024-08-27 09:45:00', '2024-08-27 12:00:00',
    CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
);

INSERT INTO olivisit.visitors (
    organisation_id, first_name, last_name, phone_number, email,
    start_time, end_time, created, modified
)
VALUES (
    '1', 'Hudson', 'Cook', '0412345698', 'hudson.cook@gmail.com',
    '2024-12-03 13:00:00', '2024-12-03 14:45:00',
    CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
);

INSERT INTO olivisit.visitors (
    organisation_id, first_name, last_name, phone_number, email,
    start_time, end_time, created, modified
)
VALUES (
    '1', 'Mila', 'Bell', '0412345699', 'mila.bell@gmail.com',
    '2025-02-14 08:00:00', '2025-02-14 09:30:00',
    CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
);

INSERT INTO olivisit.visitors (
    organisation_id, first_name, last_name, phone_number, email,
    start_time, end_time, created, modified
)
VALUES (
    '1', 'Leo', 'Morgan', '0412345700', 'leo.morgan@gmail.com',
    '2025-05-22 11:15:00', '2025-05-22 13:30:00',
    CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
);

INSERT INTO olivisit.visitors (
    organisation_id, first_name, last_name, phone_number, email,
    start_time, end_time, created, modified
)
VALUES (
    '1', 'Ava', 'Brooks', '0412345701', 'ava.brooks@gmail.com',
    '2025-09-09 09:30:00', '2025-09-09 11:00:00',
    CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
);

INSERT INTO olivisit.visitors (
    organisation_id, first_name, last_name, phone_number, email,
    start_time, end_time, created, modified
)
VALUES (
    '1', 'Samuel', 'Reid', '0412345702', 'samuel.reid@gmail.com',
    '2025-12-17 14:00:00', '2025-12-17 16:00:00',
    CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
);

INSERT INTO olivisit.visitors (
    organisation_id, first_name, last_name, phone_number, email,
    start_time, end_time, created, modified
)
VALUES (
    '1', 'Ella', 'Price', '0412345703', 'ella.price@gmail.com',
    '2026-02-11 10:00:00', '2026-02-11 12:30:00',
    CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
);

INSERT INTO olivisit.visitors (
    organisation_id, first_name, last_name, phone_number, email,
    start_time, end_time, created, modified
)
VALUES (
    '1', 'Oscar', 'Bennett', '0412345704', 'oscar.bennett@gmail.com',
    '2026-04-29 08:45:00', '2026-04-29 10:15:00',
    CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
);

INSERT INTO olivisit.visitors (
    organisation_id, first_name, last_name, phone_number, email,
    start_time, end_time, created, modified
)
VALUES (
    '1', 'Harper', 'Kelly', '0412345705', 'harper.kelly@gmail.com',
    '2026-06-18 13:30:00', '2026-06-18 16:00:00',
    CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
);

INSERT INTO olivisit.visitors (
    organisation_id, first_name, last_name, phone_number, email,
    start_time, end_time, created, modified
)
VALUES (
    '1', 'Jack', 'Richardson', '0412345706', 'jack.richardson@gmail.com',
    '2026-08-05 09:00:00', '2026-08-05 11:30:00',
    CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
);

INSERT INTO olivisit.visitors (
    organisation_id, first_name, last_name, phone_number, email,
    start_time, created, modified
)
VALUES (
    '1', 'Tiny', 'Man', '0499945706', 'Tiny.Man@gmail.com',
    '2026-08-13 010:30:00', 
    CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
);

--aldi au more
INSERT INTO olivisit.visitors (
    organisation_id,
    first_name,
    last_name,
    phone_number,
    email,
    start_time,
    end_time,
    created,
    modified
)
VALUES
('3','Ethan','Brown','0412345701','ethan.brown@gmail.com','2026-07-28 08:15:00','2026-07-28 09:45:00',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP),

('3','Charlotte','Evans','0412345702','charlotte.evans@gmail.com','2026-07-28 08:30:00','2026-07-28 11:00:00',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP),

('3','Liam','Thompson','0412345703','liam.thompson@gmail.com','2026-07-28 09:00:00',NULL,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP),

('3','Amelia','Harris','0412345704','amelia.harris@gmail.com','2026-07-28 09:10:00','2026-07-28 10:20:00',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP),

('3','Noah','Martin','0412345705','noah.martin@gmail.com','2026-07-28 09:15:00',NULL,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP),

('3','Isla','Roberts','0412345706','isla.roberts@gmail.com','2026-07-28 09:30:00','2026-07-28 12:00:00',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP),

('3','William','Anderson','0412345707','william.anderson@gmail.com','2026-07-28 09:45:00','2026-07-28 11:15:00',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP),

('3','Mia','Walker','0412345708','mia.walker@gmail.com','2026-07-28 10:00:00',NULL,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP),

('3','Lucas','White','0412345709','lucas.white@gmail.com','2026-07-28 10:15:00','2026-07-28 12:45:00',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP),

('3','Grace','King','0412345710','grace.king@gmail.com','2026-07-28 10:30:00','2026-07-28 11:45:00',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP),

('3','Henry','Scott','0412345711','henry.scott@gmail.com','2026-07-28 10:45:00',NULL,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP),

('3','Sophie','Young','0412345712','sophie.young@gmail.com','2026-07-28 11:00:00','2026-07-28 13:00:00',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP),

('3','James','Hall','0412345713','james.hall@gmail.com','2026-07-28 11:15:00','2026-07-28 12:30:00',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP),

('3','Ella','Allen','0412345714','ella.allen@gmail.com','2026-07-28 11:30:00',NULL,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP),

('3','Benjamin','Wright','0412345715','ben.wright@gmail.com','2026-07-28 11:45:00','2026-07-28 14:15:00',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP),

('3','Chloe','Green','0412345716','chloe.green@gmail.com','2026-07-28 12:00:00','2026-07-28 13:10:00',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP),

('3','Alexander','Baker','0412345717','alex.baker@gmail.com','2026-07-28 12:15:00',NULL,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP),

('3','Ava','Mitchell','0412345718','ava.mitchell@gmail.com','2026-07-28 12:30:00','2026-07-28 14:00:00',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP),

('3','Daniel','Campbell','0412345719','daniel.campbell@gmail.com','2026-07-28 13:00:00',NULL,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP),

('3','Emily','Parker','0412345720','emily.parker@gmail.com','2026-07-28 13:15:00','2026-07-28 15:00:00',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP),

('3','Matthew','Morris','0412345721','matthew.morris@gmail.com','2026-07-28 13:30:00',NULL,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP),

('3','Harper','Cook','0412345722','harper.cook@gmail.com','2026-07-28 13:45:00','2026-07-28 15:45:00',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP),

('3','Samuel','Ward','0412345723','samuel.ward@gmail.com','2026-07-28 14:00:00','2026-07-28 15:30:00',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP),

('3','Zoe','Murphy','0412345724','zoe.murphy@gmail.com','2026-07-28 14:15:00',NULL,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP),

('3','David','Cooper','0412345725','david.cooper@gmail.com','2026-07-28 14:30:00','2026-07-28 16:00:00',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP),

('3','Ruby','Bell','0412345726','ruby.bell@gmail.com','2026-07-28 14:45:00',NULL,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP),

('3','Michael','Kelly','0412345727','michael.kelly@gmail.com','2026-07-28 15:00:00','2026-07-28 17:00:00',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP),

('3','Lily','Bailey','0412345728','lily.bailey@gmail.com','2026-07-28 15:15:00',NULL,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP),

('3','Jacob','Reed','0412345729','jacob.reed@gmail.com','2026-07-28 15:30:00','2026-07-28 16:45:00',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP),

('3','Hannah','Price','0412345730','hannah.price@gmail.com','2026-07-28 15:45:00',NULL,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP);