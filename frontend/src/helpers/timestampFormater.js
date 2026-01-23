export default function timestampFormater(timestump){
    const date = new Date(timestump)
    const annee = date.getFullYear()
    const jour = String(date.getMonth()+1).padStart(2, '0')
    const mois = date.toLocaleString("fr-FR", { month: "long" })
    const heures = String(date.getHours()).padStart(2,'0')
    const minutes = String(date.getMinutes()).padStart(2,'0')
    return `${jour} ${mois} ${annee} ${heures}:${minutes}`
}