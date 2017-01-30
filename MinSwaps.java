import java.util.*;

@author Raviteja Anantha
@since 01-30-2017
public class Swaps {

	public static void main(String [] args) {
  
		int [] unsortedArray = {4, 3, 2};
		
		//Deep Copy
		int [] sortedArray = unsortedArray.clone(); 
		
		int swaps = 0;
		Arrays.sort(sortedArray);
		HashMap<Integer, Integer> hm = new HashMap<>();
		for(int i=0; i<sortedArray.length;i++){
			hm.put(sortedArray[i], i);
		}
		boolean [] visits = new boolean[unsortedArray.length];
		for(int i=0; i<visits.length; i++){
			visits[i] = false;
		}
		for(int i=0;i<unsortedArray.length;i++){
			if(visits[i] || (i == hm.get(unsortedArray[i]))){
				continue;
			}
			int cycleLength = 0;
			while(!visits[i]){
				//System.out.println("Yo");
				visits[i] = true;
				i = hm.get(unsortedArray[i]);
				cycleLength += 1;
				
			}
			swaps += cycleLength - 1;
		}
		System.out.println("Min Swaps required to sort the Array: " + swaps);
	}
}
