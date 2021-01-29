function beautifulString(inputstring) {
  var alphabet = ('abcdefghijklmnopqrstuvwxyz');
  var count = [];
  for( var i = 0; i < alphabet.length;i++){
    count[i] = 0;
    for( var j = 0; j < inputstring.length;j++){
      if(alphabet[i] == inputstring[j]){
        count[i]++;
      }
    }
  }  
}
