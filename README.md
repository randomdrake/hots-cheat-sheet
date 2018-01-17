# hots-cheat-sheet

Heroes of the Storm Cheat Sheet extracts all of the [Heroes of the Storm](http://us.battle.net/heroes/en/) builds from [Icy Veins](https://www.icy-veins.com) and puts them into CSV to create a cheat sheet.

[Download HOTS cheat sheet PDF](https://raw.githubusercontent.com/randomdrake/hots-cheat-sheet/master/cheat-sheet.pdf) (Generated January 13th, 2018)

![Cheat Sheets with Hero Builds](https://raw.githubusercontent.com/randomdrake/hots-cheat-sheet/master/cheat-sheet-hots-builds.jpg)

## Inspiration

I'm not the greatest [Heroes of the Storm](http://us.battle.net/heroes/en/) player so I generally do the following when playing a hero I'm not as familiar with:

1. Google for: "heroname build"
1. Open up the first link, which is always from [Icy Veins](https://www.icy-veins.com).
1. Write down the numbers corresponding to the talents for each build for that hero.
1. Collect a large pile of sticky notes like this:
  
  ![Sticky Notes with Hero Builds](https://raw.githubusercontent.com/randomdrake/hots-cheat-sheet/master/sticky-notes-hots-builds.jpg)
  
This required a lot of alt-tabbing, notes all over the place, and also a lot of forgetting.

This is HOTS Cheat Sheet.

## Installation / Usage

Run the `get-hots-data.php` script to generate the `cheat-sheet.csv` file. From there, I created the 3 page PDF by opening the CSV in Excel, setting the font to `10` and converting it to a table. Then I removed the sort boxes and shrank the columns to fit on a single page. Lastly I saved it to a PDF using the Print dialogue.

## How it Works

The script goes to the [Heroes of the Storm page at Icy Veins](https://www.icy-veins.com/heroes/) and extracts the links for all the hero build pages from the navigation.

From there, it goes to each page and grabs all of the builds. It associates the number of which talent it is based on the filled in images beneath the talent icons.

![Cheat Sheet PDF Preview](https://raw.githubusercontent.com/randomdrake/hots-cheat-sheet/master/cheat-sheet-pdf-preview.png)

## License

>Copyright (c) 2017 David Drake
>
>Licensed under the Apache License, Version 2.0 (the "License"); you may not use this file except in compliance with the License. You may obtain a copy of the License at
>
>http://www.apache.org/licenses/LICENSE-2.0
>
>Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the License for the specific language governing permissions and limitations under the License. 

## Author

David Drake 

[@randomdrake](https://twitter.com/randomdrake) | [https://randomdrake.com](https://randomdrake.com) | [LinkedIn](https://www.linkedin.com/in/david-drake-46524752/)

## Copyrights

[Heroes of the Storm](http://us.battle.net/heroes/en/) &copy;2017 BLIZZARD ENTERTAINMENT, INC.

[Icy Veins](https://www.icy-veins.com) &copy;2011-2017 VEDATIS S.A.S.
