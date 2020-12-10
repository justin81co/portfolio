import java.util.*;
import java.lang.*;

class Rextester
{  
    public static void main(String[] args)
    {
        
        Scanner sc = new Scanner(System.in);
        int input = sc.nextInt();
        for (int n=0;n <= input;n++) { //it is the number to be checked 
            int i,m=0,flag=0;
            m=n/2;    

            if(!(n==0||n==1))
            {
                for(i=2;i<=m;i++)
                {    
                    if(n%i==0)
                    {       
                        flag=1;    
                        break;    
                    }    
                }    
                if(flag==0)
                {
                    System.out.println(n+" is prime number");
                }
            }//end of else
        }
  
    }
}
