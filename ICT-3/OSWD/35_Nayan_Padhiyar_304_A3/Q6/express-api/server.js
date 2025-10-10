const express = require('express');
const axios = require('axios');
const app = express();
const PORT = 5000;


app.get('/products', async (req, res) => {
  try {

    const response = await axios.get('http://localhost/assignment3/07_Keyur_Bhimani_304_A3/Q6/getProducts.php');
    res.json(response.data);
  } catch (error) {
    console.error('Error calling PHP API:', error.message);
    res.status(500).json({ error: 'Failed to fetch products from PHP API' });
  }
});

app.listen(PORT, () => {
  console.log(` Express server running on http://localhost:${PORT}`);
});
