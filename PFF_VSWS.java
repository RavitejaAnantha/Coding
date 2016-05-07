import java.io.BufferedReader;
import java.io.FileReader;
import java.util.*;
public class Homework {
public static int pff(String input, int f){
int prev_pf = 0;
int cur_pf;
int count = -1;
int total_pf = 0;
LinkedHashMap<Integer, Integer> mem = new LinkedHashMap<>();
try {
	FileReader f1 = new FileReader(input);
	BufferedReader b1 = new BufferedReader(f1);
	String line; 
	while((line = b1.readLine()) != null){
		count += 1;
		if(count != 0){
			//continue;
		if(mem.containsKey(Integer.parseInt(line)))
			mem.put(Integer.parseInt(line), 1);
		else{
			cur_pf = count;
			total_pf += 1;
			if((cur_pf - prev_pf) > f){
				Iterator<Map.Entry<Integer, Integer>> itr = mem.entrySet().iterator(); 
				while(itr.hasNext()){
				Map.Entry<Integer, Integer> tuple = itr.next();
				if(tuple.getValue() == 0){
			     itr.remove();	
				}
				else{
					tuple.setValue(0);				
				}
				}
				mem.put(Integer.parseInt(line), 1);
				prev_pf = cur_pf;
			}
			else{
			mem.put(Integer.parseInt(line), 1);
			prev_pf = cur_pf;
			}
		}
		}
}
	b1.close();
}
catch(Exception e) {
	System.out.println(e);
       }
return total_pf;
	}
	 public static int vsws(String input, int M, int L, int Q) {
        int total_pf = 0;
        LinkedHashMap<Integer, Integer> mem = new LinkedHashMap<>();
        try {
            FileReader f2 = new FileReader(input);
            BufferedReader b2 = new BufferedReader(f2);
            String line;
            int count = -1, pf_per_intvl = 0;
            while ((line = b2.readLine()) != null) {
                count++;
                if (count != 0) {
                    if (mem.containsKey(Integer.parseInt(line))) {
                        mem.put(Integer.parseInt(line), 1);
                    } 
                    else {
                        total_pf++;
                        if (pf_per_intvl > Q && count >= M) {
                            Iterator<Map.Entry<Integer, Integer>> itr1 = mem.entrySet().iterator();
                            while (itr1.hasNext()) {
                                Map.Entry<Integer, Integer> entry = itr1.next();
                                if (entry.getValue() == 0) {
                                    itr1.remove();
                                } 
                                else {
                                    entry.setValue(0);
                                }
                            }
                            count = 1;
                            mem.put(Integer.parseInt(line), 1);
                            pf_per_intvl++;
                        } 
                        else {
                            mem.put(Integer.parseInt(line), 1);
                            pf_per_intvl++;
                        }
                    }
                    if (count == L) {
                        Iterator<Map.Entry<Integer, Integer>> itr2 = mem.entrySet().iterator();
                        while (itr2.hasNext()) {
                            Map.Entry<Integer, Integer> entry = itr2.next();
                            if (entry.getValue() == 0) {
                                itr2.remove();
                            } 
                            else {
                                entry.setValue(0);
                            }
                            count = 0;
                            pf_per_intvl = 0;
                        }
                    }
                }
            }
        } 
        catch (Exception e) {
            System.out.println(e);
        }
        return total_pf;
    }

public static void pff_exe(String temp){
    System.out.println("PFF Algorithm initiated......");
    int prev_total_pff;
	int cur_total_pff;
	int f = 1;
	do{
		prev_total_pff = pff(temp, f);
		System.out.println("For Frequency " + f +", number of Page Faults is/are: " + prev_total_pff);
		cur_total_pff = pff(temp, f+1);
		f += 1;
		
	}while(prev_total_pff > cur_total_pff);
	System.out.println("For Frequency " + f +", number of Page Faults is/are: " + cur_total_pff);
	System.out.println("As Frequency increases, the number of Page Faults decreases and reaches a point where the number of PAGE FAULTS becomes CONSTANT");
	System.out.println("We reached the CONSTANT point");
	System.out.println("Therefore, optimal frequency using PFF Algorithm is " + (f-1) + " with " + prev_total_pff + " Page Faults" );
	System.out.println("\nPFF Algorithm terminated......");
	System.out.println("############################################################");
}
public static void vsws_exe(String temp){
try{
    System.out.println("\nVSWS Algorithm initiated......");
    int prev_total_pf;
    int cur_total_pf;
    int M = 2;
    int L, Q;
    String s;
    FileReader f3 = new FileReader(temp);
    BufferedReader b3 = new BufferedReader(f3);
    int tl = Integer.parseInt(b3.readLine()); 
    do{
    Q = 1;
    do{ 
    L= M + Q;
    do{
    prev_total_pf = vsws(temp, M, L, Q);
    System.out.println("For M, L & Q as " + M +", "+ L +", and "+ Q + " respectively, the number of Page Faults is/are: " + prev_total_pf);
    cur_total_pf = vsws(temp, M, L+1, Q);
    L += 1;
    }while(prev_total_pf > cur_total_pf);
    if(cur_total_pf == tl){
    break;
    }
    Q++;
    }while(Q <= tl);
    M++;
    }while(cur_total_pf != tl);
    System.out.println("As Frequency increases, the number of Page Faults decreases and reaches a point where the number of PAGE FAULTS becomes CONSTANT");
	System.out.println("We reached the CONSTANT point");
	System.out.println("Therefore optimal values of M, L & Q using VSWS are " + (M-1) +", "+ (L-1) +", and "+ Q + " respectively, the number of Page Faults is/are: " + prev_total_pf);
	System.out.println("\nVSWS Algorithm terminated......");
	System.out.println("##############################################################");
    b3.close();
    }
    catch (Exception e){
    System.out.println(e);
    }
    
}

public static void main(String [] args){
	pff_exe(args[0]);
	vsws_exe(args[0]);
}
}