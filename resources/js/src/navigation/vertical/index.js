import appAndPages from './app-and-pages'
import chartsAndMaps from './charts-and-maps'
import dashboard from './dashboard'
import formsAndTables from './forms-and-tables'
import others from './others'
import uiElements from './ui-elements'
import mathMenu from './math-menu'

// Array of sections
// export default [...mathMenu]
export default [...mathMenu,...uiElements, ...formsAndTables,...appAndPages]
// export default [...dashboard, ...appAndPages, ...uiElements, ...formsAndTables, ...chartsAndMaps, ...others]
