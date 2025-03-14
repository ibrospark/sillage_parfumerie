# sillage_parfumerie
Parfumerie de luxe a Dakar
# E-Commerce Symfony Project

# Description
Ce projet est une plateforme e-commerce développée avec Symfony 7.1.10, permettant la gestion et la vente de produits en ligne, notamment des parfums. Il inclut un système de gestion des produits, des variations, des commandes et un module de paiement via PayDunya.


# Technologies utilisées
- **Backend** : Symfony 7.1.10
- **Base de données** : MySQL
- **Frontend** : Twig, Bootstrap
- **Administration** : EasyAdmin 4
- **Paiement** : Intégration PayDunya

# Entités
- Address
- Blog
- Brand
- Carrier
- Category
- Contact
- OlfactoryFamily
- OlfactoryNote
- Order
- OrderItem
- Page
- PaymentMethod
- Product
- ProductVariation
- Slider
- Store
- User

# Installation

## Prérequis
- PHP 8.2+
- Composer
- Symfony CLI
- MySQL

## Étapes
1. Cloner le projet :
   ```bash
   git clone https://github.com/ibrospark/sillage_parfumerie.git
   cd sillage_parfumerie
   ```
2. Installer les dépendances :
   ```bash
   composer install
   ```
3. Configurer l'environnement :
   - Copier le fichier `.env.example` en `.env`
   - Modifier les variables de connexion à la base de données
   
4. Créer la base de données et exécuter les migrations :
   ```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   ```
5. Lancer le serveur Symfony :
   ```bash
   symfony server:start
   ```
6. Accéder à l'application via : `http://127.0.0.1:8000`

# Commandes utiles
- Générer les migrations :
  ```bash
  php bin/console make:migration
  ```
- Charger les fixtures :
  ```bash
  php bin/console doctrine:fixtures:load
  ```

# Contribution
Les contributions sont les bienvenues !
1. Forker le projet
2. Créer une branche (`feature/ma-fonctionnalité`)
3. Faire un commit (`git commit -m "Ajout d'une nouvelle fonctionnalité"`)
4. Pousser la branche (`git push origin feature/ma-fonctionnalité`)
5. Ouvrir une Pull Request

# Licence
Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

