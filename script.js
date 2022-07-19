const championList = [
    { championName: "Aatrox", Price: 4800, imageEx: "png" },
    { championName: "Ahri", Price: 3150, imageEx: "webp" },
    { championName: "Akali", Price: 3150, imageEx: "webp" },
    { championName: "Akshan", Price: 6300, imageEx: "webp" },
    { championName: "Alistar", Price: 1350, imageEx: "webp" },
    { championName: "Amumu", Price: 450, imageEx: "webp" },
    { championName: "Anivia", Price: 3150, imageEx: "webp" },
    { championName: "Annie", Price: 450, imageEx: "webp" },
    { championName: "Aphelios", Price: 6300, imageEx: "webp" },
    { championName: "Ashe", Price: 450, imageEx: "webp" },
    { championName: "Aurelion Sol", Price: 6300, imageEx: "png" },
    { championName: "Azir", Price: 4800, imageEx: "webp" },
    { championName: "Bard", Price: 4800, imageEx: "webp" },
    { championName: "Blitzcrank", Price: 3150, imageEx: "webp" },
    { championName: "Brand", Price: 4800, imageEx: "webp" },
    { championName: "Braum", Price: 4800, imageEx: "webp" },
  ];
  let coins = 0;
  const coinsText = document.getElementById("coins");
  coinsText.innerText = "Coins:  " + coins;

  function buildChampion() {
    const table = document.querySelectorAll("table");
    table[1].innerHTML = "";
    for (let i = 0; i < championList.length; i++) {
      Price = undefined;
      if (championList[i].Price > coins) {
        Price = `<h2 style="color:#FF595E;">${championList[i].Price}</h2>`;
      } else {
        Price = `<h2 style="color:#8AC926;">${championList[i].Price}</h2>`;
      }
      let img =
        championList[i].championName + "Square." + championList[i].imageEx;
      img = img.replace(/\s/g, "");
      const champion = `
      <tr class="champion">
        <td class="textAlign" style="border-radius: 10px 0px 0px 10px">
          <img class="championImg" src="icons/${img}" />
        </td>
        <td class="textAlign"><h2>${championList[i].championName}</h2></td>
        <td style="border-radius: 0px 10px 10px 0px" class="textAlign">
          ${Price}
        </td>
      </tr>`;
      table[1].innerHTML += champion;
    }
    const champion = document.querySelectorAll(".champion");
    for (let i = 0; i < champion.length; i++) {
      champion[i].addEventListener("click", () => {
        if (championList[i].Price <= coins) {
          coins -= championList[i].Price;
          coinsText.innerText = "Coins:  " + coins;
          championList.splice(i, 1);
          buildChampion();
        } else {
          alert(
            "You don't have enough coins,click the button 'Give me Coins' to earn some."
          );
        }
      });
    }
  }
  document.querySelector("a").addEventListener("click", () => {
    addCoins();
  });
  function addCoins() {
    let inputCoins = prompt("Coins:");
    coins += Number(inputCoins);
    coinsText.innerText = "Coins:  " + coins;
    buildChampion();
  }
  buildChampion();