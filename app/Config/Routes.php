<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

// =============================================
// OPÉRATEUR
// =============================================
$routes->get('operateur/prefixes', 'Operateur::prefixes');
$routes->get('operateur/ajouter-prefixe', 'Operateur::ajouterPrefixeForm');
$routes->post('operateur/ajouter-prefixe', 'Operateur::ajouterPrefixe');
$routes->get('operateur/operations', 'Operateur::operations');
$routes->get('operateur/ajouter-bareme', 'Operateur::ajouterBaremeForm');
$routes->post('operateur/ajouter-bareme', 'Operateur::ajouterBareme');
$routes->get('operateur/clients', 'Operateur::clients');
$routes->get('operateur/gains', 'Operateur::gains');

// =============================================
// CLIENT
// =============================================
$routes->get('client/login', 'Client::login');
$routes->get('client/do-login', 'Client::doLogin');
$routes->get('client/compte', 'Client::compte');
$routes->get('client/logout', 'Client::logout');
$routes->get('client/depot', 'Client::depot');
$routes->get('client/do-depot', 'Client::doDepot');
$routes->get('client/retrait', 'Client::retrait');
$routes->get('client/do-retrait', 'Client::doRetrait');

$routes->get('client/transfert', 'Client::transfert');
$routes->get('client/do-transfert', 'Client::doTransfert');
$routes->get('client/historique', 'Client::historique');

$routes->get('operateur/commissions', 'Operateur::commissions');

$routes->get('operateur/config-intra-fee', 'Operateur::configIntraFee');
$routes->get('operateur/update-intra-fee', 'Operateur::updateIntraFee');

$routes->get('client/epargne', 'Client::epargne');
$routes->get('client/do-epargne', 'Client::doEpargne');

$routes->get('operateur/config-epargne', 'Operateur::configEpargne');
$routes->get('operateur/update-epargne-rate', 'Operateur::updateEpargneRate');