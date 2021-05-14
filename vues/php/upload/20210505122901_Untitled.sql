CREATE TABLE `users` (
  `id_user` int PRIMARY KEY,
  `login` string,
  `password` string,
  `nom` string,
  `prenom` string,
  `email` string
);

CREATE TABLE `logiciels` (
  `id_logiciel` int PRIMARY KEY,
  `nom` string,
  `code` string,
  `id_type` int,
  `liste_poluants` string,
  `version_client` float,
  `version_upgrade` float
);

CREATE TABLE `logiciel_type` (
  `id_type` int,
  `libelle` string
);

CREATE TABLE `contact` (
  `id_contact` int PRIMARY KEY,
  `nom` string,
  `prenom` string,
  `fonction` string,
  `adresse1` string,
  `adresse2` string,
  `cp` string,
  `ville` string,
  `pays` string,
  `tel` string,
  `mobile` string,
  `fax` string,
  `email1` string,
  `email2` string,
  `com` string,
  `id_societe` int
);

CREATE TABLE `societes` (
  `id_societe` int PRIMARY KEY,
  `nom` string,
  `agence` string,
  `adresse1` string,
  `adresse2` string,
  `cp` string,
  `ville` string,
  `pays` string,
  `tel` string,
  `fax` string,
  `siret` string,
  `tva` string,
  `com` string,
  `id_groupe` int,
  `id_type` int
);

CREATE TABLE `societes_grp` (
  `id_groupe` int PRIMARY KEY,
  `libelle` string,
  `fournisseur` string
);

CREATE TABLE `societes_type` (
  `id_type` int PRIMARY KEY,
  `libelle` string
);

CREATE TABLE `devis` (
  `id_devis` int PRIMARY KEY,
  `numero` string,
  `ancien_numero` string,
  `libelle` string,
  `date_attestation_client` string,
  `date_renouv_licence` string,
  `date_renouv_maintenance` string,
  `etat` string,
  `montant` string,
  `soustraitance` string,
  `lieuformation` string,
  `com` string,
  `details` string,
  `id_type` int,
  `id_logiciel` int,
  `id_societe` int,
  `id_user_auteur` int
);

CREATE TABLE `devis_type` (
  `id_type` int PRIMARY KEY,
  `libelle` string,
  `code` string
);

CREATE TABLE `logiciels_options` (
  `id_option` int PRIMARY KEY,
  `libelle` string,
  `acceptee` string,
  `id_logiciel` int
);

CREATE TABLE `historique_logiciels_options` (
  `id_historique` int PRIMARY KEY,
  `dateDebutOption` string,
  `dateFinOption` string,
  `tarif` string,
  `libelle` string,
  `id_options` int
);

CREATE TABLE `licences` (
  `id_licence` int PRIMARY KEY,
  `numero` string,
  `data_achat` string,
  `date_mise_operation` string,
  `date_fin_fourniture_meteo` string,
  `exp_maintenance` string,
  `exp_licence` string,
  `id_logiciel` int,
  `id_upgrade` int,
  `id_installation` int,
  `id_type` int,
  `id_devis` int,
  `id_contact` int,
  `id_societe` int
);

CREATE TABLE `licences_installation` (
  `id_installation` int PRIMARY KEY,
  `libelle` string
);

CREATE TABLE `licences_types` (
  `id_type` int PRIMARY KEY,
  `libelle` string
);

ALTER TABLE `logiciel_type` ADD FOREIGN KEY (`id_type`) REFERENCES `logiciels` (`id_type`);

ALTER TABLE `logiciels` ADD FOREIGN KEY (`id_logiciel`) REFERENCES `licences` (`id_logiciel`);

ALTER TABLE `logiciels` ADD FOREIGN KEY (`id_logiciel`) REFERENCES `devis` (`id_logiciel`);

ALTER TABLE `devis_type` ADD FOREIGN KEY (`id_type`) REFERENCES `devis` (`id_type`);

ALTER TABLE `societes_type` ADD FOREIGN KEY (`id_type`) REFERENCES `societes` (`id_type`);

ALTER TABLE `societes_grp` ADD FOREIGN KEY (`id_groupe`) REFERENCES `societes` (`id_groupe`);

ALTER TABLE `societes` ADD FOREIGN KEY (`id_societe`) REFERENCES `devis` (`id_societe`);

ALTER TABLE `contact` ADD FOREIGN KEY (`id_contact`) REFERENCES `licences` (`id_contact`);

ALTER TABLE `societes` ADD FOREIGN KEY (`id_societe`) REFERENCES `contact` (`id_societe`);

ALTER TABLE `societes` ADD FOREIGN KEY (`id_societe`) REFERENCES `licences` (`id_societe`);

ALTER TABLE `licences` ADD FOREIGN KEY (`id_devis`) REFERENCES `devis` (`id_devis`);

ALTER TABLE `licences_types` ADD FOREIGN KEY (`id_type`) REFERENCES `licences` (`id_type`);

ALTER TABLE `users` ADD FOREIGN KEY (`id_user`) REFERENCES `devis` (`id_user_auteur`);

ALTER TABLE `logiciels` ADD FOREIGN KEY (`id_logiciel`) REFERENCES `logiciels_options` (`id_logiciel`);

ALTER TABLE `historique_logiciels_options` ADD FOREIGN KEY (`id_options`) REFERENCES `logiciels_options` (`id_option`);

ALTER TABLE `licences_installation` ADD FOREIGN KEY (`id_installation`) REFERENCES `licences` (`id_installation`);
