<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Met à jour la fonction trigger pour lire l'utilisateur applicatif
        // défini via SET app.current_user = '...' depuis Laravel
        DB::unprepared("
            CREATE OR REPLACE FUNCTION fn_audit_depense()
            RETURNS TRIGGER AS \$\$
            DECLARE
                v_user TEXT;
            BEGIN
                -- Récupère l'utilisateur applicatif passé par Laravel,
                -- sinon retombe sur l'utilisateur PostgreSQL courant
                v_user := COALESCE(
                    NULLIF(current_setting('app.current_user', true), ''),
                    current_user
                );

                IF (TG_OP = 'INSERT') THEN
                    INSERT INTO audit_depenses (type_action, date_operation, n_depense, nom_etab, ancien_depense, nouv_depense, utilisateur)
                    SELECT 'Ajout', NOW(), NEW.n_depense, e.nom, 0, NEW.depense, v_user
                    FROM etablissements e WHERE e.n_etab = NEW.n_etab;

                    UPDATE etablissements
                    SET montant_budget = montant_budget + NEW.depense - 0
                    WHERE n_etab = NEW.n_etab;

                    RETURN NEW;

                ELSIF (TG_OP = 'UPDATE') THEN
                    INSERT INTO audit_depenses (type_action, date_operation, n_depense, nom_etab, ancien_depense, nouv_depense, utilisateur)
                    SELECT 'Modification', NOW(), NEW.n_depense, e.nom, OLD.depense, NEW.depense, v_user
                    FROM etablissements e WHERE e.n_etab = NEW.n_etab;

                    UPDATE etablissements
                    SET montant_budget = montant_budget + NEW.depense - OLD.depense
                    WHERE n_etab = NEW.n_etab;

                    RETURN NEW;

                ELSIF (TG_OP = 'DELETE') THEN
                    INSERT INTO audit_depenses (type_action, date_operation, n_depense, nom_etab, ancien_depense, nouv_depense, utilisateur)
                    SELECT 'Suppression', NOW(), OLD.n_depense, e.nom, OLD.depense, 0, v_user
                    FROM etablissements e WHERE e.n_etab = OLD.n_etab;

                    UPDATE etablissements
                    SET montant_budget = montant_budget + 0 - OLD.depense
                    WHERE n_etab = OLD.n_etab;

                    RETURN OLD;
                END IF;

                RETURN NULL;
            END;
            \$\$ LANGUAGE plpgsql;
        ");
    }

    public function down(): void
    {
        // Restaure la version originale avec current_user PostgreSQL
        DB::unprepared("
            CREATE OR REPLACE FUNCTION fn_audit_depense()
            RETURNS TRIGGER AS \$\$
            BEGIN
                IF (TG_OP = 'INSERT') THEN
                    INSERT INTO audit_depenses (type_action, date_operation, n_depense, nom_etab, ancien_depense, nouv_depense, utilisateur)
                    SELECT 'Ajout', NOW(), NEW.n_depense, e.nom, 0, NEW.depense, current_user
                    FROM etablissements e WHERE e.n_etab = NEW.n_etab;

                    UPDATE etablissements
                    SET montant_budget = montant_budget + NEW.depense - 0
                    WHERE n_etab = NEW.n_etab;

                    RETURN NEW;

                ELSIF (TG_OP = 'UPDATE') THEN
                    INSERT INTO audit_depenses (type_action, date_operation, n_depense, nom_etab, ancien_depense, nouv_depense, utilisateur)
                    SELECT 'Modification', NOW(), NEW.n_depense, e.nom, OLD.depense, NEW.depense, current_user
                    FROM etablissements e WHERE e.n_etab = NEW.n_etab;

                    UPDATE etablissements
                    SET montant_budget = montant_budget + NEW.depense - OLD.depense
                    WHERE n_etab = NEW.n_etab;

                    RETURN NEW;

                ELSIF (TG_OP = 'DELETE') THEN
                    INSERT INTO audit_depenses (type_action, date_operation, n_depense, nom_etab, ancien_depense, nouv_depense, utilisateur)
                    SELECT 'Suppression', NOW(), OLD.n_depense, e.nom, OLD.depense, 0, current_user
                    FROM etablissements e WHERE e.n_etab = OLD.n_etab;

                    UPDATE etablissements
                    SET montant_budget = montant_budget + 0 - OLD.depense
                    WHERE n_etab = OLD.n_etab;

                    RETURN OLD;
                END IF;

                RETURN NULL;
            END;
            \$\$ LANGUAGE plpgsql;
        ");
    }
};
