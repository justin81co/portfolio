function isBeautifulString(inputString) {
    var alphabet = ('abcdefghijklmnopqrstuvwxyz');
    var isBeautiful = true;
    var count = [];
    for( var i = 0; i < alphabet.length;i++){
        count[i] = 0;
        for( var j = 0; j < inputString.length;j++){
            if(alphabet[i] == inputString[j]){
                count[i]++;
            }
        }
        if (i > 0){
            if (count[i-1]<count[i]){
                isBeautiful = false;
                return false;
            }
            
        }
    }
    return isBeautiful;
}
