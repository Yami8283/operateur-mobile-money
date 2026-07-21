# Tâches - Version 1

## Étudiant 1 (ETU4224)
- Création du dépôt GitHub et structure initiale
- Base de données (base.sql) : tables opérateurs, préfixes, types opérations, barèmes, clients, comptes, transactions
- Contrôleur Operateur : préfixes, opérations, barèmes, clients, gains
- Contrôleur Client : login, compte, dépôt, retrait
- Vues opérateur et client
- Routes

## Étudiant 2 (ETU4195)
- Modèles : OperatorModel, PrefixModel, OperationTypeModel, FeeBandModel, ClientModel, AccountModel, TransactionModel
- Tests et débogage
- Bootstrap et mise en page

# Tâches - Version 2

## Étudiant 1 (ETU4224)
- Mise à jour base.sql : multi-opérateurs, table operator_commissions
- Modification OperatorModel : getAllWithPrefixes()
- Mise à jour contrôleur Operateur : préfixes multi-opérateurs, gains séparés (local vs autres), commissions
- Vues opérateur : préfixes, gains, commissions, clients, opérations, ajouter barème
- CSS luxe sur toutes les vues

## Étudiant 2 (ETU4195)
- Option frais de retrait inclus
- Envoi multiple vers plusieurs numéros (même opérateur)
- Pas de frais pour autres opérateurs
- Modification doTransfert() : transfert simple inter-opérateur, envoi multiple intra-opérateur
- Tests commissions inter-opérateurs
