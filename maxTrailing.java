import java.io.*;
import java.math.*;
import java.security.*;
import java.text.*;
import java.util.*;
import java.util.concurrent.*;
import java.util.regex.*;


class Result {

    /*
     * Complete the 'maxTrailing' function below.
     *
     * The function is expected to return an INTEGER.
     * The function accepts INTEGER_ARRAY levels as parameter.
     */

    public static int maxTrailing(List<Integer> levels) {
        int trailingRecord = 0,tempLow, tempHigh = 0, delta;
        int numLevels = levels.size();
        tempLow = levels.get(0);
        if (numLevels==1){
            trailingRecord = -1;
        }
        if (numLevels==2){
            if (levels.get(1) <= tempLow){
                trailingRecord = -1;
            }
            else {
                trailingRecord = levels.get(1) - tempLow;
            }
        }
        else {
            for (int i = 1;i<levels.size();i++){
                int temp = levels.get(i);
                if (temp<=tempLow){
                    tempLow = temp;
                }
                else {
                    delta = temp - tempLow;
                    if(delta > trailingRecord){
                        trailingRecord = delta;
                    }
                }
            }
        }
        if (trailingRecord <=0) {
            trailingRecord = -1;
        }
        return trailingRecord;
    }

}
public class Solution {
    public static void main(String[] args) throws IOException {
        BufferedReader bufferedReader = new BufferedReader(new InputStreamReader(System.in));
        BufferedWriter bufferedWriter = new BufferedWriter(new FileWriter(System.getenv("OUTPUT_PATH")));

        int levelsCount = Integer.parseInt(bufferedReader.readLine().trim());

        List<Integer> levels = new ArrayList<>();

        for (int i = 0; i < levelsCount; i++) {
            int levelsItem = Integer.parseInt(bufferedReader.readLine().trim());
            levels.add(levelsItem);
        }

        int result = Result.maxTrailing(levels);

        bufferedWriter.write(String.valueOf(result));
        bufferedWriter.newLine();

        bufferedReader.close();
        bufferedWriter.close();
    }
}
