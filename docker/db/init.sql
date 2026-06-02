-- 1. TABELA RÓL (Słownikowa)
CREATE TABLE roles (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);

-- Wrzucamy od razu podstawowe role
INSERT INTO roles (name) VALUES ('Klient'), ('Admin');

-- 2. TABELA UŻYTKOWNIKÓW (Relacja 1:N z tabelą roles)
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    role_id INTEGER NOT NULL REFERENCES roles(id) ON DELETE RESTRICT,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password TEXT NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- 3. TABELA SZCZEGÓŁÓW UŻYTKOWNIKA (Relacja 1:1 z tabelą users)
CREATE TABLE user_details (
    user_id INTEGER PRIMARY KEY REFERENCES users(id) ON DELETE CASCADE,
    full_name VARCHAR(100),
    shipping_address TEXT,
    phone_number VARCHAR(20)
);

-- 4. TABELA MAKIET GÓR (Produkty w sklepie)
CREATE TABLE products (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price NUMERIC(10, 2) NOT NULL,
    scale VARCHAR(20), -- np. 1:10000
    image_url VARCHAR(255),
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- 5. TABELA ZAMÓWIEŃ (Relacja 1:N z tabelą users)
CREATE TABLE orders (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    total_amount NUMERIC(10, 2) DEFAULT 0,
    status VARCHAR(20) DEFAULT 'PENDING',
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- 6. TABELA POŚREDNICZĄCA KOSZYKA/ZAMÓWIENIA (Relacja M:N dla orders i products)
CREATE TABLE order_items (
    order_id INTEGER NOT NULL REFERENCES orders(id) ON DELETE CASCADE,
    product_id INTEGER NOT NULL REFERENCES products(id) ON DELETE RESTRICT,
    quantity INTEGER NOT NULL CHECK (quantity > 0),
    price_at_purchase NUMERIC(10, 2) NOT NULL,
    PRIMARY KEY (order_id, product_id)
);

-- ==========================================
-- FUNKCJE I WYZWALACZE (Wymóg z regulaminu)
-- ==========================================

-- Funkcja: Automatyczna aktualizacja kolumny updated_at
CREATE OR REPLACE FUNCTION update_timestamp_column()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ language 'plpgsql';

-- Wyzwalacz (Trigger): Nasłuchuje zmian (UPDATE) na tabeli users i odpala funkcję
CREATE TRIGGER update_users_timestamp
    BEFORE UPDATE ON users
    FOR EACH ROW
    EXECUTE FUNCTION update_timestamp_column();

-- ==========================================
-- WIDOKI (Min. 2 widoki z JOIN, wymóg z regulaminu)
-- ==========================================

-- Widok 1: Podsumowanie zamówień użytkowników (łączenie 2 tabel)
CREATE VIEW v_user_orders_summary AS
SELECT o.id AS order_id, u.email, o.total_amount, o.status, o.created_at
FROM orders o
JOIN users u ON o.user_id = u.id;

-- Widok 2: Szczegóły koszyka/zamówienia (łączenie 3 tabel)
CREATE VIEW v_order_details AS
SELECT oi.order_id, p.name AS mountain_name, oi.quantity, oi.price_at_purchase, (oi.quantity * oi.price_at_purchase) AS subtotal
FROM order_items oi
JOIN products p ON oi.product_id = p.id;

