-- =========================================
-- Base de données : blog_app
-- =========================================

CREATE DATABASE IF NOT EXISTS blog_app
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE blog_app;

-- =========================================
-- Table users
-- =========================================
CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    avatar VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =========================================
-- Table posts
-- =========================================
CREATE TABLE posts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    title VARCHAR(200) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_posts_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE INDEX idx_posts_user_id ON posts(user_id);

-- =========================================
-- Table comments
-- =========================================
CREATE TABLE comments (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    post_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_comments_post
        FOREIGN KEY (post_id)
        REFERENCES posts(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_comments_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;


-- Données de test--
-- =========================================
-- Insertion de 12 utilisateurs
-- =========================================
INSERT INTO users (name, email, password, avatar) VALUES
('Alexandre Martin', 'alex.martin@email.com', '$2y$10$hashedpassword', 'avatar1.jpg'),
('Sophie Dubois', 'sophie.dubois@email.com', '$2y$10$hashedpassword', 'avatar2.jpg'),
('Thomas Leroy', 'thomas.leroy@email.com', '$2y$10$hashedpassword', 'avatar3.jpg'),
('Emma Laurent', 'emma.laurent@email.com', '$2y$10$hashedpassword', 'avatar4.jpg'),
('Lucas Bernard', 'lucas.bernard@email.com', '$2y$10$hashedpassword', 'avatar5.jpg'),
('Chloé Petit', 'chloe.petit@email.com', '$2y$10$hashedpassword', 'avatar6.jpg'),
('Nicolas Roux', 'nicolas.roux@email.com', '$2y$10$hashedpassword', 'avatar7.jpg'),
('Julie Moreau', 'julie.moreau@email.com', '$2y$10$hashedpassword', 'avatar8.jpg'),
('Antoine Simon', 'antoine.simon@email.com', '$2y$10$hashedpassword', 'avatar9.jpg'),
('Camille Fournier', 'camille.fournier@email.com', '$2y$10$hashedpassword', 'avatar10.jpg'),
('Maxime Lefebvre', 'maxime.lefebvre@email.com', '$2y$10$hashedpassword', 'avatar11.jpg'),
('Sarah Girard', 'sarah.girard@email.com', '$2y$10$hashedpassword', 'avatar12.jpg');

-- =========================================
-- Insertion de 30 posts sur le développement web et mobile
-- =========================================
INSERT INTO posts (user_id, title, content) VALUES
(1, 'Les bases de React en 2024', 'React continue d évoluer avec de nouvelles fonctionnalités. Dans cet article, nous explorons les hooks les plus utiles et les meilleures pratiques pour structurer vos applications.'),
(2, 'Introduction à Vue.js 3', 'Vue.js 3 apporte de nombreuses améliorations avec la Composition API. Découvrez comment migrer depuis Vue 2 et tirer parti des nouvelles possibilités.'),
(3, 'Développement mobile avec Flutter', 'Flutter permet de créer des applications natives pour iOS et Android avec un seul codebase. Voyons comment débuter avec ce framework prometteur.'),
(4, 'Les Progressive Web Apps (PWA)', 'Les PWA combinent le meilleur du web et des applications mobiles. Guide complet pour transformer votre site web en PWA.'),
(5, 'Optimisation des performances web', 'Techniques avancées pour améliorer le temps de chargement : lazy loading, code splitting, optimisation des images et bien plus.'),
(6, 'State Management avec Redux Toolkit', 'Redux Toolkit simplifie la gestion d état dans les applications React. Tutoriel pas à pas avec des exemples concrets.'),
(7, 'API REST vs GraphQL', 'Comparatif détaillé entre REST et GraphQL pour vos APIs backend. Quels sont les avantages et inconvénients de chaque approche ?'),
(8, 'Sécurité des applications web', 'Meilleures pratiques pour sécuriser vos applications : injection SQL, XSS, CSRF et authentification JWT.'),
(9, 'Docker pour le développement web', 'Comment containeriser vos applications web avec Docker pour un environnement de développement cohérent et reproductible.'),
(10, 'Tests unitaires en JavaScript', 'Guide complet sur les tests avec Jest et Testing Library pour vos applications React et Vue.'),
(1, 'Next.js pour le SSR', 'Next.js révolutionne le Server-Side Rendering avec React. Découvrez comment créer des applications performantes et SEO-friendly.'),
(2, 'Animations avec CSS et JavaScript', 'Créer des animations fluides et performantes pour améliorer l expérience utilisateur de vos sites web.'),
(3, 'React Native vs Flutter', 'Comparaison approfondie entre React Native et Flutter pour le développement d applications mobiles cross-platform.'),
(4, 'Micro-frontends Architecture', 'Comment découper votre application frontend en micro-applications indépendantes pour une meilleure maintenabilité.'),
(5, 'WebAssembly : le futur du web ?', 'Exploration des possibilités offertes par WebAssembly pour exécuter du code compilé directement dans le navigateur.'),
(6, 'TypeScript pour des projets JavaScript solides', 'Pourquoi et comment migrer vos projets JavaScript vers TypeScript pour un code plus robuste et maintenable.'),
(7, 'CI/CD pour applications web', 'Mettre en place un pipeline de déploiement continu avec GitHub Actions ou GitLab CI pour automatiser vos livraisons.'),
(8, 'Accessibilité web (a11y)', 'Guide essentiel pour rendre vos sites web accessibles à tous les utilisateurs, conformément aux normes WCAG.'),
(9, 'Serverless avec AWS Lambda', 'Développer des applications backend sans serveur avec AWS Lambda et API Gateway. Cas d utilisation et bonnes pratiques.'),
(10, 'WebSockets en temps réel', 'Implémentation de fonctionnalités en temps réel avec WebSockets pour les chats, notifications et jeux en ligne.'),
(11, 'Tailwind CSS : utilitaires first', 'Découverte de Tailwind CSS et comment ce framework utility-first peut accélérer votre développement frontend.'),
(12, 'MongoDB et Mongoose pour Node.js', 'Manipulation de bases de données NoSQL avec MongoDB et l ODM Mongoose dans des applications Node.js.'),
(11, 'Nuxt.js pour applications Vue universelles', 'Créer des applications Vue.js avec rendu côté serveur, génération de sites statiques et routing automatique.'),
(12, 'Authentification moderne avec OAuth 2.0', 'Implémentation d un système d authentification sécurisé avec OAuth 2.0 et OpenID Connect.'),
(1, 'Web Components et Shadow DOM', 'Utilisation des standards du web pour créer des composants réutilisables indépendants des frameworks.'),
(2, 'Écologie numérique et développement web', 'Comment réduire l impact environnemental de vos sites web : optimisation, hébergement vert et bonnes pratiques.'),
(3, 'Kotlin Multiplatform pour mobile', 'Développement d applications mobiles partageant du code entre iOS et Android avec Kotlin Multiplatform.'),
(4, 'Jamstack : l architecture moderne du web', 'Exploration de l architecture Jamstack (JavaScript, APIs, Markup) et de ses avantages pour les performances et sécurité.'),
(5, 'Design Systems avec Storybook', 'Création et maintenance d un design system cohérent avec Storybook pour vos composants UI.'),
(6, 'Web3 et développement décentralisé', 'Introduction au développement d applications décentralisées (dApps) avec Ethereum et les smart contracts.');

-- =========================================
-- Insertion de 40 commentaires de discussion
-- =========================================
INSERT INTO comments (post_id, user_id, content) VALUES
-- Commentaires sur le post 1 (React)
(1, 3, 'Excellent article ! Les hooks ont vraiment révolutionné ma façon de coder en React.'),
(1, 7, 'Est-ce que tu recommandes d utiliser useContext pour la gestion d état globale ?'),
(1, 5, 'Attention à l effet de closure dans les hooks, c est un piège courant pour les débutants.'),

-- Commentaires sur le post 2 (Vue.js 3)
(2, 1, 'La Composition API est un vrai game-changer ! Beaucoup plus flexible que les Options API.'),
(2, 8, 'La migration depuis Vue 2 a été plus simple que prévue grâce aux outils officiels.'),
(2, 4, 'Est-ce que Vue 3 est compatible avec toutes les librairies Vue 2 ?'),

-- Commentaires sur le post 3 (Flutter)
(3, 6, 'Flutter est génial mais la courbe d apprentissage est assez raide au début.'),
(3, 2, 'Les hot reloads changent la vie ! Développer des UI n a jamais été aussi rapide.'),
(3, 10, 'Comment gères-tu la communication avec les APIs REST dans Flutter ?'),

-- Commentaires sur le post 4 (PWA)
(4, 9, 'Les PWA ont sauvé notre projet qui n avait pas le budget pour des apps natives.'),
(4, 3, 'Le caching stratégique est crucial pour les PWA offline. Quelles stratégies recommandes-tu ?'),
(4, 11, 'Les notifications push ont boosté notre engagement de 40% !'),

-- Commentaires sur le post 5 (Performance)
(5, 12, 'Le lazy loading des images avec intersection observer est devenu indispensable.'),
(5, 4, 'As-tu des outils à recommander pour mesurer les performances Core Web Vitals ?'),

-- Commentaires sur le post 6 (Redux)
(6, 8, 'Redux Toolkit a vraiment simplifié la configuration de Redux, fini le boilerplate !'),
(6, 1, 'Est-ce que tu utilises Redux pour toute ton application ou seulement certains états ?'),

-- Commentaires sur le post 7 (API)
(7, 5, 'GraphQL est génial mais n oublions pas que REST est encore parfait pour beaucoup de cas.'),
(7, 9, 'Le problème avec GraphQL c est la courbe d apprentissage pour l équipe backend.'),

-- Commentaires sur le post 8 (Sécurité)
(8, 2, 'Les attaques XSS sont encore trop courantes. Content Security Policy est essentiel !'),
(8, 6, 'Pour les JWT, pensez à implémenter un système de refresh token sécurisé.'),

-- Commentaires sur le post 9 (Docker)
(9, 10, 'Docker Compose est parfait pour orchestrer plusieurs services (frontend, backend, DB).'),
(9, 7, 'Attention aux volumes Docker en production, il faut bien gérer les permissions.'),

-- Commentaires sur le post 10 (Tests)
(10, 3, 'Les tests d intégration sont aussi importants que les tests unitaires !'),
(10, 11, 'Testing Library encourage de meilleures pratiques en testant comme un utilisateur.'),

-- Commentaires sur le post 11 (Next.js)
(11, 4, 'Le SEO amélioré avec Next.js a boosté notre trafic organique de 60% !'),
(11, 8, 'Les API Routes de Next.js sont pratiques pour les petits projets.'),

-- Commentaires sur le post 12 (Animations)
(12, 5, 'Les animations au scroll avec Intersection Observer donnent vie au site.'),
(12, 9, 'Attention aux performances avec les animations JavaScript, toujours préférer CSS quand possible.'),

-- Commentaires sur le post 13 (React Native vs Flutter)
(13, 1, 'React Native a l avantage de la communauté mais Flutter a des performances impressionnantes.'),
(13, 6, 'Le choix dépend surtout des compétences de l équipe et du projet.'),

-- Commentaires sur le post 14 (Micro-frontends)
(14, 7, 'Les micro-frontends sont géniaux pour les grandes équipes mais overkill pour les petits projets.'),

-- Commentaires sur le post 15 (WebAssembly)
(15, 10, 'WebAssembly ouvre des possibilités incroyables pour le traitement d images/vidéo dans le navigateur.'),

-- Commentaires sur le post 16 (TypeScript)
(16, 2, 'TypeScript a réduit nos bugs de 70% après la migration. Incontournable maintenant !'),
(16, 12, 'La phase de migration peut être longue mais ça vaut vraiment le coup.'),

-- Commentaires sur le post 17 (CI/CD)
(17, 3, 'GitHub Actions est très bien intégré mais peut devenir cher pour les gros projets.'),

-- Commentaires sur le post 18 (Accessibilité)
(18, 5, 'L accessibilité n est pas une option ! Pensez aux lecteurs d écran dès le début.'),

-- Commentaires sur le post 19 (Serverless)
(19, 8, 'Le cold start des fonctions Lambda peut être problématique pour certaines applications.'),

-- Commentaires sur le post 20 (WebSockets)
(20, 4, 'Socket.IO simplifie énormément l implémentation des WebSockets avec fallback.'),

-- Commentaires sur le post 21 (Tailwind CSS)
(21, 6, 'Tailwind m a fait gagner un temps fou sur les projets de style. Plus de CSS à écrire !'),

-- Commentaires sur le post 22 (MongoDB)
(22, 9, 'Mongoose est excellent mais n oubliez pas de bien valider vos données côté schéma.'),

-- Commentaires sur le post 23 (Nuxt.js)
(23, 1, 'Nuxt 3 avec Vue 3 est vraiment stable maintenant. Je recommande !'),

-- Commentaires sur le post 24 (OAuth)
(24, 7, 'OAuth 2.0 est complexe mais nécessaire pour une sécurité professionnelle.'),

-- Commentaires sur le post 25 (Web Components)
(25, 10, 'Les Web Components sont prometteurs mais manquent encore d écosystème.'),

-- Commentaires sur le post 26 (Écologie)
(26, 2, 'L hébergement vert devrait être la norme maintenant. Merci pour cet article !'),

-- Commentaires sur le post 27 (Kotlin Multiplatform)
(27, 11, 'Kotlin Multiplatform partage vraiment du code métier efficacement entre iOS et Android.'),

-- Commentaires sur le post 28 (Jamstack)
(28, 3, 'Jamstack + CDN = des performances imbattables et une sécurité améliorée.'),

-- Commentaires sur le post 29 (Design Systems)
(29, 12, 'Storybook a transformé notre façon de documenter les composants. Indispensable !'),

-- Commentaires sur le post 30 (Web3)
(30, 5, 'Web3 est encore jeune mais les possibilités sont immenses. À suivre de près !');