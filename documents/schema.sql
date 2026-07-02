CREATE TABLE "piece_jointe" (
	"id"	INTEGER NOT NULL UNIQUE,
	"email_emetteur"	TEXT NOT NULL,
	"email_destinataire"	TEXT NOT NULL,
	"date_creation"	INTEGER NOT NULL,
	"chemin"	TEXT NOT NULL,
	PRIMARY KEY("id" AUTOINCREMENT)
);

CREATE TABLE "legal_info" (
    "id" INTEGER PRIMARY KEY AUTOINCREMENT,
    "section" TEXT NOT NULL,
    "key" TEXT NOT NULL,
    "value" TEXT NOT NULL,
    "created_at" INTEGER DEFAULT (strftime('%s', 'now')),
    "updated_at" INTEGER DEFAULT (strftime('%s', 'now')),
    UNIQUE(section, key)
);

INSERT INTO "legal_info" (section, key, value) VALUES
('editeur', 'firstName', 'John'),
('editeur', 'lastName', 'Doe'),
('editeur', 'voi', '1'),
('editeur', 'rue', 'Rue de l''Exemple'),
('editeur', 'codepostal', '75000'),
('editeur', 'ville', 'Paris'),
('editeur', 'departement', 'Paris'),
('editeur', 'pays', 'France'),
('editeur', 'tel', '0123456789'),
('editeur', 'email', 'contact@example.com'),

('hebergeur', 'name', 'o2switch'),
('hebergeur', 'legal_form', 'SAS'),
('hebergeur', 'registration', 'RCS Clermont-Ferrand'),
('hebergeur', 'tel', '0444446040'),
('hebergeur', 'url', 'https://www.o2switch.fr/'),

('rgpd', 'data_retention', '7 jours'),
('rgpd', 'log_retention', '12 mois'),

('cgu', 'last_update', '2024-01-01'),
('privacy', 'last_update', '2024-01-01'),
('legal', 'last_update', '2024-01-01');
