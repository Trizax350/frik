const char = 'a';

async function getWordsFromURL(url){
  try {
    const response = await fetch(url);
    const html = await response.text();

    //DOMParser
    const parser = new DOMParser();
    const doc = parser.parseFromString(html, 'text/html');

    const words = [];
    const allText = doc.body.textContent;

    const wordList = allText.split(/\s+/);

    for(let i = 0; i < wordList.length; i++){
      let word = wordList[i].toLowerCase();
      word = word.replace('.','');
      word = word.replace(',','');
      word = word.replace(':','');
      word = word.replace(';','');
      word = word.replace('!','');
      word = word.replace('?','');
      if(word.includes(char) && 
        !word.includes('{') && 
        !word.includes('[') && 
        !word.includes('(') && 
        !word.includes('_') && 
        !word.includes('/') && 
        !word.includes("'") && 
        !word.includes('"') && 
        !words.includes(word)){
        words.push(word);
        if(words.length === 64){
          break;
        }
      }
    }

    return words;
  } catch(error){
    console.error('Hiba történt:', error);
  }
}

//A táblázat létrehozása
function createWordTable(words){
  const table = document.createElement('table');
  let wordIndex = 0;

  for(let i = 0; i < 8; i++){
    const row = document.createElement('tr');

    for(let j = 0; j < 8; j++){
      const cell = document.createElement('td');
      if(wordIndex < words.length){
        cell.textContent = words[wordIndex];
        wordIndex++;
      }
      row.appendChild(cell);
    }
    table.appendChild(row);
  }
  return table;
}

const urlInput = document.getElementById('urlInput');
const submitButton = document.getElementById('submitButton');
const wordTableContainer = document.getElementById('wordTableContainer');

submitButton.addEventListener('click', async () => {
  const url = urlInput.value.trim();

  if(url !== ''){
    // Weboldal letöltése és szavak kinyerése
    const words = await getWordsFromURL(url);

    // Táblázat létrehozása és megjelenítése
    const wordTable = createWordTable(words);
    wordTableContainer.innerHTML = '';
    wordTableContainer.appendChild(wordTable);
  }
});