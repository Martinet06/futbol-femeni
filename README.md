# ⚽ Futbol Femení

Aplicació Laravel per a la gestió de futbol femení: equips, jugadores, partits i resultats.

## 🧩 Requisits

- PHP ≥ 8.1  
- Composer  
- Node.js & NPM  
- Base de dades (MySQL, SQLite, o similar)

## ⚙️ Instal·lació

```bash
# Clonar el repositori
git clone https://github.com/Martinet06/futbol-femeni.git
cd futbol-femeni

# Instal·lar dependències PHP
composer install

# Instal·lar dependències front-end
npm install && npm run build

# Configurar l'entorn
cp .env.example .env
php artisan key:generate

# Crear base de dades i executar migracions
php artisan migrate --seed

## ⚽ Funcionalitats

- **Gestió de jugadores**
  - Crear, editar i eliminar jugadores.

- **Gestió de partits**
  - Assignació d’equips locals i visitants.
  - Possibilitat d’afegir el resultat del partit.

- **Validacions**
  - `local` i `visitant` → requerits i **han de ser diferents**.
  - `data` → requerida, amb format **Y-m-d**.
  - `resultat` → opcional, però amb format **`\d+-\d+`** (exemple: `2-1`).

- **Estils bàsics**
  - **Taules** amb colors alterns i capçaleres destacades.
  - **Formularis** amb etiquetes, camps i botons coherents.
  - **Alertes** per a missatges d’èxit, error i informació.
