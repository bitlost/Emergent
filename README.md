## Emergent Example

An simple json api, which does the following...

The game consists of an MxN grid.  The grid is divided into cells.  Each cell is either “on” or “off”. 

The api will be used to animate the grid by displaying successive “generations.”  The rules for calculating generation G + 1 given generation G are as follows:

Count the number of 'on' cells surrounding each cell on the board. If the number of 'on' cells is less than two, that cell is 'off' for the next generation. If the number of 'on' cells is two, that cell stays the same. If the number of 'on' cells is three, the cell becomes 'on'. If the number of cells is greater than three, the cell becomes 'off'.
