<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Fonction trigger PostgreSQL
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

        // Trigger attaché à la table depenses
        DB::unprepared("
            CREATE TRIGGER trg_audit_depense
            AFTER INSERT OR UPDATE OR DELETE ON depenses
            FOR EACH ROW EXECUTE FUNCTION fn_audit_depense();
        ");
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_audit_depense ON depenses;');
        DB::unprepared('DROP FUNCTION IF EXISTS fn_audit_depense();');
    }
};
