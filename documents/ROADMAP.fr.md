## Feuille de route de développement – MiniTrello (Symfony UX)

Cette roadmap décrit un plan de développement progressif pour une application de gestion de tâches de type Trello, en utilisant Symfony 6.4+ et Symfony UX. Elle met l’accent sur la modularité, l’UX moderne et une architecture propre côté serveur.

---

### Phase 0 – Initialisation du projet

- Créer un nouveau projet Symfony avec les assets web
- Installer les dépendances nécessaires :
  - Doctrine ORM
  - Twig
  - Symfony UX (Stimulus, Turbo, Twig Components)
- Configurer la base de données (MySQL ou SQLite)
- Créer un layout de base (`base.html.twig`)

---

### Phase 1 – Modélisation des données

- Créer l’entité `Project` (titre)
- Créer l’entité `Column` :
  - Titre
  - Position (pour le tri)
  - Relation many-to-one vers `Project`
- Créer l’entité `Card` :
  - Titre
  - Description
  - isDone (booléen)
  - Position
  - Relation many-to-one vers `Column`
- Générer et exécuter les migrations
- Créer des fixtures de test

---

### Phase 2 – Rendu statique de l’interface

- Afficher la page d’un projet avec :
  - Toutes ses colonnes
  - Toutes les cartes par colonne
- Utiliser des composants Twig pour :
  - Le rendu des colonnes
  - Le rendu des cartes
- Appliquer un style de base avec SCSS ou TailwindCSS

---

### Phase 3 – Gestion dynamique des cartes

- Ajouter un formulaire d’ajout dans chaque colonne
- Créer un contrôleur Stimulus pour :
  - Soumettre le formulaire via `fetch`
  - Insérer la carte dans le DOM dynamiquement
- Réinitialiser le formulaire après ajout
- Afficher une confirmation visuelle

---

### Phase 4 – Marquage des tâches comme terminées

- Ajouter une case à cocher ou un bouton "terminé"
- Mettre à jour l’état via Stimulus ou Turbo
- Modifier visuellement la carte (ex : barré, atténué)

---

### Phase 5 – Suppression des cartes

- Ajouter un bouton de suppression sur chaque carte
- Traiter la suppression dynamiquement (fetch/Turbo)
- Supprimer la carte du DOM après validation

---

### Phase 6 – Glisser-déposer (Drag & Drop)

- Intégrer une librairie de drag & drop (ex. `sortablejs`)
- Permettre de réorganiser les cartes dans une colonne
- Autoriser le déplacement de cartes entre colonnes
- Mettre à jour les positions et associations côté serveur

---

### Phase 7 – Authentification (optionnelle)

- Implémenter l’inscription et la connexion utilisateur
- Associer chaque projet à son propriétaire
- Restreindre les accès avec des règles de sécurité
- Utiliser `is_granted()` pour gérer les autorisations

---

### Phase 8 – Fonctionnalités avancées (optionnel)

- Ajouter des tags ou étiquettes aux cartes
- Gérer des dates d’échéance et des filtres
- Réorganiser les colonnes
- Permettre l’édition en ligne (Live Components)
- Créer une API REST pour clients externes
- Rendre l’interface responsive mobile
- Ajouter des options de partage et collaboration

---

### Checklist Qualité & Sécurité

- Protection CSRF sur tous les formulaires
- Validation des données avec contraintes Symfony
- Contrôle d’accès (`security.yaml`, annotations)
- Architecture claire : contrôleurs, services, vues
- Dégradation progressive si JavaScript désactivé
