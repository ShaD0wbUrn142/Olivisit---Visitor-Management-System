-- Populating fake data into the Admin Table

INSERT INTO olivisit.admin (
    first_name,
    last_name,
    phone_number,
    email,
    password,
    created,
    modified
)
VALUES (
    'David',
    'Dave',
    '0485736283',
    'daviddave@gmail.com',
    'DavidisanAdmin1',
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
);

INSERT INTO olivisit.admin (
    first_name,
    last_name,
    phone_number,
    email,
    password,
    created,
    modified
)
VALUES (
    'admin',
    'admin',
    '0909000000',
    'admin@gmail.com',
    'admin',
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
);