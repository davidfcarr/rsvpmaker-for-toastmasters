export default function mytranslate(term,data) {
    if(!data || !data.hasOwnProperty("translations") || !data.translations[term]) {
        console.log('Missed translation',term);
        return term;
    }
    return data.translations[term];
}