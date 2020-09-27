CREATE DATABASE wallet
    CHARACTER SET utf8
    COLLATE utf8_general_ci;

CREATE TABLE wallet.`user` (
	user_id INTEGER UNSIGNED auto_increment NOT NULL,
	name VARCHAR(255) NOT NULL,
	document VARCHAR(255) NOT NULL,
	email VARCHAR(255) NOT NULL,
	password VARCHAR(255) NOT NULL,
	CONSTRAINT user_PK PRIMARY KEY (user_id),
	CONSTRAINT user_document_UN UNIQUE KEY (document),
	CONSTRAINT user_email_UN UNIQUE KEY (email)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_general_ci;

CREATE TABLE wallet.user_wallet (
    wallet_id INTEGER UNSIGNED auto_increment NOT NULL,
    user_id INTEGER UNSIGNED NOT NULL,
    debit FLOAT DEFAULT 0.00 NOT NULL,
    credit FLOAT DEFAULT 0.00 NOT NULL,
    CONSTRAINT user_wallet_PK PRIMARY KEY (wallet_id),
    CONSTRAINT user_wallet_FK FOREIGN KEY (user_id) REFERENCES wallet.`user`(user_id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_general_ci;

CREATE TABLE wallet.transfer (
    transfer_id INTEGER UNSIGNED auto_increment NOT NULL,
    user_payer_id INTEGER UNSIGNED NOT NULL,
    user_payee_id INTEGER UNSIGNED NOT NULL,
    amount FLOAT NOT NULL,
    CONSTRAINT transfer_PK PRIMARY KEY (transfer_id),
    CONSTRAINT transfer_FK_1 FOREIGN KEY (user_payer_id) REFERENCES wallet.`user`(user_id),
    CONSTRAINT transfer_FK FOREIGN KEY (user_payee_id) REFERENCES wallet.`user`(user_id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_general_ci;
