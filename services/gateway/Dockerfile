FROM node:20-alpine

# Répertoire de travail
WORKDIR /app

# Copier les fichiers package
COPY package*.json ./

# Installer les dépendances
RUN npm install --production

# Copier le reste du code
COPY . .

# Exposer le port
EXPOSE 3000

# Démarrer le gateway
CMD ["node", "src/index.js"]
