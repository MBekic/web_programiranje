const express = require('express');
const path = require('path');
const fs = require('fs');

const app = express();
const PORT = process.env.PORT || 3000;

// Statičke datoteke iz public mape
app.use(express.static(path.join(__dirname, 'public')));

// EJS
app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, 'views'));

// Početna stranica
app.get('/', (req, res) => {
  res.sendFile(path.join(__dirname, 'public', 'index.html'));
});

// Dinamička galerija
app.get('/slike', (req, res) => {
  const dataPath = path.join(__dirname, 'images.json');
  const images = JSON.parse(fs.readFileSync(dataPath, 'utf8'));
  res.render('slike', { images });
});

app.listen(PORT, () => {
  console.log(`Server pokrenut na http://localhost:${PORT}`);
});