-- Populating fake data into the House Rules Table

-- cqu
INSERT INTO olivisit.houserules (
    name,
    rule_description,
    organisation_id,
    expiry_date,
    created,
    modified
)
VALUES (
    'CQUniversity Rules',
    'Please do not run in the hallway',
    '1',
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
);
--woolworths

INSERT INTO olivisit.houserules (
    name,
    rule_description,
    organisation_id,
	expiry_date,
    created,
    modified
)
VALUES (
    'Woolworths Rules',
    'Baskets: Shopping baskets must stay inside the store and cannot be taken out into the car park.',
    '2',
    NULL,
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
);

INSERT INTO olivisit.houserules (
    name,
    rule_description,
    organisation_id,
	expiry_date,
    created,
    modified
)
VALUES (
    'Woolworths Rules',
    'Bags and Backpacks: Standard policy allows school bags and personal backpacks inside stores, though individual locations may occasionally ask you to keep them visible or cooperate with security requests.',
    '2',
    NULL,
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
);

INSERT INTO olivisit.houserules (
    name,
    rule_description,
    organisation_id,
	expiry_date,
    created,
    modified
)
VALUES (
    'Woolworths Rules',
    'Service Options: If you prefer not to go inside, you can use online ordering for parking lot Direct to boot pickup.',
    '2',
    NULL,
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
);

--Aldi 
INSERT INTO olivisit.houserules (
    name,
    rule_description,
    organisation_id,
	expiry_date,
    created,
    modified
)
VALUES (
    'Aldi Rules',
    'Coin deposit: Insert a coin (like a $1 or $2 coin in Australia, or a quarter in the US) to unlock a shopping cart. You get the coin back when you lock the cart back up.',
    '3',
	NULL,
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
);

INSERT INTO olivisit.houserules (
    name,
    rule_description,
    organisation_id,
	expiry_date,
    created,
    modified
)
VALUES (
    'Aldi Rules',
    'Coin deposit: Insert a coin (like a $1 or $2 coin in Australia, or a quarter in the US) to unlock a shopping cart. You get the coin back when you lock the cart back up.',
    '4',
	'2027-07-28 11:45:00',
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
);

INSERT INTO olivisit.houserules (
    name,
    rule_description,
    organisation_id,
    expiry_date,
    created,
    modified
)
VALUES (
    'Aldi Rules',
    'Bags: Bring your own reusable bags or boxes. Aldi does not provide free plastic bags, but you can buy bags at the register or grab empty product boxes from the aisles.',
    '3',
	'2027-07-28 11:45:00',
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
);

INSERT INTO olivisit.houserules (
    name,
    rule_description,
    organisation_id,
    expiry_date,
    created,
    modified
)
VALUES (
    'Aldi Rules',
    'Bags: Bring your own reusable bags or boxes. Aldi does not provide free plastic bags, but you can buy bags at the register or grab empty product boxes from the aisles.',
    '4',
	'2027-07-28 11:45:00',
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
);

