CREATE TABLE IF NOT EXISTS operators (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name TEXT NOT NULL,
  intra_fee_percent REAL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS prefixes (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  operator_id INTEGER NOT NULL,
  prefix TEXT NOT NULL,
  FOREIGN KEY(operator_id) REFERENCES operators(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS operation_types (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name TEXT NOT NULL,
  code TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS fee_bands (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  operation_type_id INTEGER NOT NULL,
  min_amount INTEGER NOT NULL,
  max_amount INTEGER NOT NULL,
  fee_flat INTEGER DEFAULT 0,
  fee_percent REAL DEFAULT 0,
  FOREIGN KEY(operation_type_id) REFERENCES operation_types(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS clients (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  phone TEXT NOT NULL UNIQUE,
  name TEXT
);

CREATE TABLE IF NOT EXISTS accounts (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  client_id INTEGER NOT NULL UNIQUE,
  balance INTEGER NOT NULL DEFAULT 0,
  FOREIGN KEY(client_id) REFERENCES clients(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS transactions (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  client_from INTEGER,
  client_to INTEGER,
  operation_type_id INTEGER NOT NULL,
  amount INTEGER NOT NULL,
  fee INTEGER NOT NULL DEFAULT 0,
  created_at TEXT DEFAULT CURRENT_TIMESTAMP,
  reference TEXT,
  FOREIGN KEY(client_from) REFERENCES clients(id),
  FOREIGN KEY(client_to) REFERENCES clients(id),
  FOREIGN KEY(operation_type_id) REFERENCES operation_types(id)
);

-- Seed operator and prefixes
INSERT INTO operators (name) VALUES ('Operator Demo');
INSERT INTO prefixes (operator_id, prefix) VALUES (1, '033');
INSERT INTO prefixes (operator_id, prefix) VALUES (1, '037');

-- Operation types: deposit, withdrawal, transfer
INSERT INTO operation_types (name, code) VALUES ('Dépôt', 'deposit');
INSERT INTO operation_types (name, code) VALUES ('Retrait', 'withdraw');
INSERT INTO operation_types (name, code) VALUES ('Transfert', 'transfer');

-- Fee bands example (amounts in cents)
-- Retrait: small fee for <=5000, larger for >5000
INSERT INTO fee_bands (operation_type_id, min_amount, max_amount, fee_flat, fee_percent) VALUES (2, 0, 500000, 100, 0); -- 1.00 currency
INSERT INTO fee_bands (operation_type_id, min_amount, max_amount, fee_flat, fee_percent) VALUES (2, 500001, 1000000000, 500, 0); -- 5.00 currency

-- Transfert: percent based
INSERT INTO fee_bands (operation_type_id, min_amount, max_amount, fee_flat, fee_percent) VALUES (3, 0, 1000000000, 0, 1.0); -- 1% fee

-- Sample client
INSERT INTO clients (phone, name) VALUES ('0330000001', 'Alice');
INSERT INTO clients (phone, name) VALUES ('0370000002', 'Bob');

INSERT INTO accounts (client_id, balance) VALUES (1, 100000); -- 1000.00
INSERT INTO accounts (client_id, balance) VALUES (2, 50000);  -- 500.00

-- Sample transactions
INSERT INTO transactions (client_from, client_to, operation_type_id, amount, fee, reference) VALUES (NULL, 1, 1, 50000, 0, 'DEP-001');
INSERT INTO transactions (client_from, client_to, operation_type_id, amount, fee, reference) VALUES (1, NULL, 2, 20000, 100, 'WDR-001');
INSERT INTO transactions (client_from, client_to, operation_type_id, amount, fee, reference) VALUES (1, 2, 3, 10000, 100, 'TRF-001');
-- ============================================
-- Version 2 - Multi-opérateurs
-- ============================================

-- Table des commissions inter-opérateurs
CREATE TABLE IF NOT EXISTS operator_commissions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    from_operator_id INTEGER NOT NULL,
    to_operator_id INTEGER NOT NULL,
    commission_percent REAL NOT NULL DEFAULT 0,
    FOREIGN KEY(from_operator_id) REFERENCES operators(id),
    FOREIGN KEY(to_operator_id) REFERENCES operators(id)
);

CREATE TABLE IF NOT EXIST savings(
  id INTEGER PRIMARY KEY AUTOCRIMENT ,
  client_id INTEGER NOT NULL UNIQUE ,
  amount INTEGER NOT NULL DEFAULT 0 ,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  update_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY(client_id)REFERENCE clients(id)
)

-- Nouveaux opérateurs
INSERT INTO operators (name) VALUES ('Operator B');
INSERT INTO operators (name) VALUES ('Operator C');

-- Préfixes pour les nouveaux opérateurs
INSERT INTO prefixes (operator_id, prefix) VALUES (2, '032');
INSERT INTO prefixes (operator_id, prefix) VALUES (2, '031');
INSERT INTO prefixes (operator_id, prefix) VALUES (3, '034');
INSERT INTO prefixes (operator_id, prefix) VALUES (3, '035');

-- Commissions inter-opérateurs (opérateur 1 vers 2 et 3)
INSERT INTO operator_commissions (from_operator_id, to_operator_id, commission_percent) VALUES (1, 2, 2.0);
INSERT INTO operator_commissions (from_operator_id, to_operator_id, commission_percent) VALUES (1, 3, 3.0);

-- Clients pour les nouveaux opérateurs
INSERT INTO clients (phone, name) VALUES ('0320000001', 'Charlie');
INSERT INTO clients (phone, name) VALUES ('0340000001', 'David');
INSERT INTO accounts (client_id, balance) VALUES (3, 100000);
INSERT INTO accounts (client_id, balance) VALUES (4, 100000);

UPDATE operators SET intra_fee_percent = 1.0 WHERE id = 1;

sqlite3 writable/database.db "ALTER TABLE operators ADD COLUMN intra_fee_percent REAL DEFAULT 0;"
