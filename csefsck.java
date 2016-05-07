import java.io.*;
import java.util.*;
public class csefsck {
private static int BLOCK_SIZE = 4096;
//private static int POINTER_SIZE = 10;
private static long CURRENT_EPOCH_TIME;
private static String SUPER_BLOCK = "FS/fusedata.0";
private static String path = "FS/fusedata.";
private static int DEVICE_ID = 20;
private static int FREE_START = 1;
private static int FREE_END;
private static int MAX_BLOCKS;
private static int ROOT = 26;


	public String file_Reader(String fname){
		String line = null;
		//String data = null;

		try {
			FileReader f1 = new FileReader(fname);
			BufferedReader b1 = new BufferedReader(f1);

			line = b1.readLine();
			b1.close();
		}
		catch(Exception e) {
			System.out.println(e);
		}
		return line;
	}


	public void free_Block_Checker(){
		System.out.println("\nFree Block List Checker initiated...\n");
		List<String> s = new ArrayList<String>();
		String s1 = file_Reader(SUPER_BLOCK);
		String freeStart = s1.substring(s1.indexOf("freeStart:") + 10, s1.indexOf(",", s1.indexOf("freeStart:")));
		//System.out.println(freeStart);
		String freeend = s1.substring(s1.indexOf("freeEnd:") + 8, s1.indexOf(",", s1.indexOf("freeEnd:")));
		//System.out.println(freeend);
		String maxBlocks = s1.substring(s1.indexOf("maxBlocks:") + 10, s1.indexOf("}", s1.indexOf("maxBlocks:")));
		//System.out.println(maxBlocks);

		MAX_BLOCKS = Integer.parseInt(maxBlocks);
		double fe = Math.ceil(Double.parseDouble(maxBlocks)/400);
		FREE_END = (int) fe;
		//String s1 = br.readLine();
		//s.addAll(Arrays.asList(s1.split(", ")));
		for(int i = FREE_START;i < FREE_END+1;i++){
			s1 = file_Reader(path + i);
			s.addAll(Arrays.asList(s1.split(", ")));
		}


		for(int i=FREE_END+1;i<MAX_BLOCKS;i++){
			String file = path;
			try {
				File f = new File(file+i);
				if (f.exists() == false && s.contains(String.valueOf(i)) == false){ 

					System.out.println("We're in Block " + i + "\nOops, It is free, but it is not included in the free block list\n");
					System.out.println("Fixing it...\n");
					for(int j = FREE_START;j < FREE_END+1;j++){
						String temp = file_Reader(file + j);
						String [] tarr = temp.split(",");
						if(tarr.length > 400)
							continue;
						else{
							//String y = file_Reader(file + j);
							temp = temp + ", " + i;
							PrintWriter pw = new PrintWriter(file + j);
							pw.println(temp);
							pw.close();
							break;
						}

					}
					System.out.println("The free block is NOW added to the free block list\n");
				}
				else if(f.exists() && s.contains(i)){
					System.out.println("We're in Block " + i + "\nOops, It isn't free, but it is included in the free block list\n");
					for(int q= FREE_START; q<= FREE_END; q++){
						String td = file_Reader(file + q);
						String fval = td.substring(0, td.indexOf(","));
						String lval = td.substring(td.lastIndexOf(",")+1);
						if(("" + i).equals(fval)){
							td = td.substring(td.indexOf(",")+2);
						}
						else if(("" + i).equals(lval)){
							td = td.substring(0, td.lastIndexOf(","));
						}
						else{
							if(td.contains(", " + i + ",")){
								int ind = td.indexOf(", " + i + ",");
								int size = (", " + i + ",").length();
								td = td.substring(0, ind) + td.substring(ind + size - 1);
							}
						}
						PrintWriter pw = new PrintWriter(file + q);
						pw.println(td);
						pw.close();
					}
					System.out.println("The block is NOW deleted from the free block list\n");
				}
				else if(f.exists()) //&& s.contains(String.valueOf(i)) == false))
					System.out.println("We're in Block " + i + "\nIt isn't free, and not included in the free block list\n");
				else
					System.out.println("We're in Block " + i + "\nIt is free, and included in the free block list\n");
			}

			catch (Exception e) {
				System.out.println(e);	
			}
		}
		System.out.println("\nFree Block List Checker terminated!!!\n");
		//System.out.println("--------------------------------------");
	}
	public void super_Block_Checker(){
		System.out.println("\nSuper Block Checker initiated...\n");
		String s1 = file_Reader(SUPER_BLOCK);

		// Checking Creation Time
		String temp = s1.substring(s1.indexOf("creationTime")+13, s1.indexOf(",", 0)).trim();
		CURRENT_EPOCH_TIME = (System.currentTimeMillis())/1000;
		String currentString = String.valueOf(CURRENT_EPOCH_TIME);
		String [] splitter = s1.split(",");

		//System.out.println(CURRENT_EPOCH_TIME);
		if(currentString.compareTo(temp) < 0){       //If current time < creation time
			System.out.println("Oops, Creation Time of your Super Block is Incorrect, i.e. it's in the future\n");
			System.out.println("Fixing it...\n");
			splitter[0] = "creationTime: " + CURRENT_EPOCH_TIME;
			String ns = "";
			for(int i=0; i<splitter.length; i++){
				ns = ns + splitter[i] + ",";
			}
			ns = ns.substring(0, ns.lastIndexOf(","));
			try{ PrintWriter w = new PrintWriter(SUPER_BLOCK);
			w.println(ns);
			System.out.println("Super Block Creation time is NOW correct\n");
			w.close();
			}
			catch(Exception e){
				System.out.println(e);
			}
		}
		else
			System.out.println("Super Block Creation Time is correct\n");

		//Checking Device ID
		String tempid = s1.substring(s1.indexOf("devId:") + 6, s1.indexOf(",", s1.indexOf("devId:")));
		if (tempid.equals(String.valueOf(DEVICE_ID)) == false){
			System.out.println("Oops, DeviceID is incorrect!!!");
			System.out.println("Fixing it...\n");
			splitter[2] = " devId:" + DEVICE_ID;
			String ns = "";
			for(int i=0; i<splitter.length; i++){
				ns = ns + splitter[i] + ",";
			}
			ns = ns.substring(0, ns.lastIndexOf(","));
			try{ 
				PrintWriter w = new PrintWriter(SUPER_BLOCK);
				w.println(ns);
				System.out.println("Super Block Device ID is NOW correct\n");
				w.close();
			}
			catch(Exception e){
				System.out.println(e);
			}            
		}
		else
			System.out.println("Super Block Device ID is correct\n");


		//Block Size Verification
		String freeStart = s1.substring(s1.indexOf("freeStart:") + 10, s1.indexOf(",", s1.indexOf("freeStart:")));
		//System.out.println(freeStart);
		String freeend = s1.substring(s1.indexOf("freeEnd:") + 8, s1.indexOf(",", s1.indexOf("freeEnd:")));
		//System.out.println(freeend);
		String maxBlocks = s1.substring(s1.indexOf("maxBlocks:") + 10, s1.indexOf("}", s1.indexOf("maxBlocks:")));
		//System.out.println(maxBlocks);

		MAX_BLOCKS = Integer.parseInt(maxBlocks);
		double FE = Math.ceil(Double.parseDouble(maxBlocks)/400);
		FREE_END = (int) FE;
		//We can't fix the FREE_END as we don't know what the number of free blocks could be...  
		if(freeStart.equals(String.valueOf(FREE_START)) == false){
			System.out.println("Oops, Free Block List Start is incorrect");
		}
		if(Integer.parseInt(freeend)>FREE_END){
			System.out.println("Oops, Free Block List End is incorrect");
		}

		/*//Get location of root directory
        ROOT = Integer.parseInt(s1.substring(s1.indexOf("root:") + 5, s1.indexOf(",", s1.indexOf("root"))));
        if(ROOT!=FREE_END+1){
            System.out.println("Oops, Root should be stored on block "+FREE_END+1);
        }*/
		System.out.println("\nSuper Block Checker terminated!!!\n");
		//System.out.println("-----------------------------------");
	}
	public void directory_Checker(String dirname){

		String data = file_Reader(dirname);
		int d1 = dirname.indexOf(".") + 1;
		String dot = dirname.substring(d1);
		System.out.println("\nDirectory Checker Initiated for directory with path: " + dirname + "\n");
		CURRENT_EPOCH_TIME = (System.currentTimeMillis())/1000;
		String [] splitter = data.split(",");

		//Check Times
		String atime = data.substring(data.indexOf("atime") + 6, data.indexOf(",", data.indexOf("atime")));
		String ctime = data.substring(data.indexOf("ctime") + 6, data.indexOf(",", data.indexOf("ctime")));
		String mtime = data.substring(data.indexOf("mtime") + 6, data.indexOf(",", data.indexOf("mtime")));

		if(String.valueOf(CURRENT_EPOCH_TIME).compareTo(atime) < 0){       //If current time < access time
			System.out.println("Oops, Access Time of your Directory is Incorrect, i.e. it's in the future\n");
			System.out.println("Fixing it...\n");
			splitter[4] = " atime:" + CURRENT_EPOCH_TIME;
			String ns = "";
			for(int i=0; i<splitter.length; i++){
				ns = ns + splitter[i] + ",";
			}
			ns = ns.substring(0, ns.lastIndexOf(","));
			try{ 
				PrintWriter w = new PrintWriter(dirname);
				w.println(ns);
				System.out.println("Directory Access Time is NOW Correct\n");
				w.close();
			}
			catch(Exception e){
				System.out.println(e);
			}
		}
		else
			System.out.println("Access Time of your Directory is Correct\n");
		
		if(String.valueOf(CURRENT_EPOCH_TIME).compareTo(ctime) < 0){       //If current time < creation time
			System.out.println("Oops, Creation Time of your Directory is Incorrect, i.e. it's in the future\n");
			System.out.println("Fixing it...\n");
			splitter[5] = " ctime:" + CURRENT_EPOCH_TIME;
			String ns = "";
			for(int i=0; i<splitter.length; i++){
				ns = ns + splitter[i] + ",";
			}
			ns = ns.substring(0, ns.lastIndexOf(","));
			try{ 
				PrintWriter w = new PrintWriter(dirname);
				w.println(ns);
				System.out.println("Directory Creation Time is NOW Correct\n");
				w.close();
			}
			catch(Exception e){
				System.out.println(e);
			}
		}
		else
			System.out.println("Creation Time of your Directory is Correct\n");
		if(String.valueOf(CURRENT_EPOCH_TIME).compareTo(mtime) < 0){       //If current time < modified time
			System.out.println("Oops, Modification Time of your Directory is Incorrect, i.e. it's in the future\n");
			System.out.println("Fixing it...\n");
			splitter[6] = " mtime:" + CURRENT_EPOCH_TIME;
			String ns = "";
			for(int i=0; i<splitter.length; i++){
				ns = ns + splitter[i] + ",";
			}
			ns = ns.substring(0, ns.lastIndexOf(","));
			try{ 
				PrintWriter w = new PrintWriter(dirname);
				w.println(ns);
				System.out.println("Directory Modification Time is NOW Correct\n");
				w.close();
			}
			catch(Exception e){
				System.out.println(e);
			}
		}
		else
			System.out.println("Modification Time of your Directory is Correct\n");
		
		//Checking dot and dot dot

		String currentdir = data.substring(data.indexOf("d:.:")+4, data.indexOf(",", data.indexOf("d:.:")));
		String prevdir = "";
		String t = file_Reader(SUPER_BLOCK);
		String rt = t.substring(t.indexOf("root:") + 5, t.indexOf(",", t.indexOf("root:")));
		ROOT = Integer.parseInt(rt);
		if(dirname.equals(path + String.valueOf(ROOT))){
			prevdir = data.substring(data.indexOf("d:..:")+5, data.indexOf(",", data.indexOf("d:..:")));
		}
		else{
			prevdir = data.substring(data.indexOf("d:..:")+5, data.indexOf("}", data.indexOf("d:..:")));
		}
		if(currentdir.equals("")== true){
            System.out.println("Oops, Current Directory value is not present!\n");
			
        }
		if(currentdir.equals(dot) == false){
			System.out.println("Oops, Current Directory value is corrupted!!!\n");
	
		}
		

		if(prevdir.equals("") == true){
			System.out.println("Oops, Parent Directory value is not present!\n");
			if (dirname == path + ROOT){
				System.out.println("Parent Directory value is " + ROOT + "\n");
		
			}
		}

		if(currentdir.equals(String.valueOf(ROOT)) == true && prevdir.equals(String.valueOf(ROOT)) == false){
			System.out.println("Oops, Parent Directory value is corrupted!!!\n");
			if (dirname == path + ROOT){
				System.out.println("Parent Directory value is " + ROOT + "\n");
		
			}
		}

        //Checking Link Count
		String lcount = data.substring(data.indexOf("linkcount:")+10, data.indexOf(",", data.indexOf("linkcount:")));

		String filesline = data.substring(data.indexOf("filename_to_inode_dict:")+25, data.indexOf("}", data.indexOf("filename_to_inode_dict:")));
		//System.out.println("Hi " + filesline);

		List<List<String>> fileList = new ArrayList<List<String>>();
		List<List<String>> dirList = new ArrayList<List<String>>();

		int loc = 0;
		String dnm, point;
		char type;
		while(loc<= filesline.length()){
			type = filesline.charAt(loc);
			dnm = filesline.substring(loc+2,filesline.indexOf(":",loc + 2));

			if(loc > filesline.lastIndexOf(',')){
				point = filesline.substring(filesline.indexOf(":", loc + 2) + 1, filesline.length());
				loc = filesline.length() + 1;
			}
			else{
				point = filesline.substring(filesline.indexOf(":", loc + 2) + 1, filesline.indexOf(",",loc + 2));
				loc = filesline.indexOf(",",loc + 1) + 2;
			}
			//System.out.println("test " + type+" : "+ dnm + " : " + point);
			if(type == 'd'){
				dirList.add(Arrays.asList(dnm, point));
				//System.out.println("Added to dir list");
			}
			if(type == 'f'){
				fileList.add(Arrays.asList(dnm, point));
				//System.out.println("Added to file list");
			}
		}
		int lc = Integer.parseInt(lcount);
		//System.out.println(lc);

		if (lc == (fileList.size() + dirList.size()))
			System.out.println("Link Count matches the number of links in the filename_to_inode_dict\n");
		else{
			System.out.println("Link Count doesn't match the number of links in the filename_to_inode_dict\n");
			System.out.println("Correcting the link count...\n");
			splitter[7] = " linkcount:" + (fileList.size() + dirList.size());
			String ts = "";
			for(int k=0; k<splitter.length; k++){
				ts = ts + splitter[k] + ",";
			}
			try{
	            PrintWriter gh = new PrintWriter(dirname);
	            gh.println(ts.substring(0, ts.lastIndexOf(",")));
	            System.out.println("Link Count Corrected\n");
	            gh.close();
	            }
	            catch (Exception e){
	            	System.out.println(e);
	            }
		
		}

		System.out.println("File List:\n");
		if (fileList.isEmpty()){
			System.out.println("No Files contained in this Directory\n");
		}
		else{
			for(List<String> l:fileList ){
				for(String item:l){
					System.out.print(item+"  ");
				}
				System.out.println("");
			}
		}
		if (dirList.isEmpty()){
			System.out.println("No Sub-Directories contained in this Directory\n");
		}
		else{
			System.out.println("Directory List:\n");
			for(List<String> l:dirList ){
				for(String item:l){
					System.out.print(item   +"  ");
				}
				System.out.println("");
			}
		}
		System.out.println("\nDirectory with path: "+dirname+" checking is complete.\n");
	}
	public void file_Checker(String filename){

		String data = file_Reader(filename);
		CURRENT_EPOCH_TIME = (System.currentTimeMillis())/1000;
		System.out.println("File Checker Initiated, Checking File with path: " + filename + "\n");

		String [] splitter = data.split(",");


		//Checking Time
		String atime = data.substring(data.indexOf("atime") + 6, data.indexOf(",", data.indexOf("atime")));
		String ctime = data.substring(data.indexOf("ctime") + 6, data.indexOf(",", data.indexOf("ctime")));
		String mtime = data.substring(data.indexOf("mtime") + 6, data.indexOf(",", data.indexOf("mtime")));

		if(String.valueOf(CURRENT_EPOCH_TIME).compareTo(atime) < 0){       //If current time < access time
			System.out.println("Oops, Access Time of your File is Incorrect, i.e. it's in the future\n");
			System.out.println("Fixing it...\n");
			splitter[5] = " atime:" + CURRENT_EPOCH_TIME;
			String ns = "";
			for(int i=0; i<splitter.length; i++){
				ns = ns + splitter[i] + ",";
			}
			ns = ns.substring(0, ns.lastIndexOf(","));
			try{ 
				PrintWriter w = new PrintWriter(filename);
				w.println(ns);
				System.out.println("File Access Time is NOW correct\n");
				w.close();
			}
			catch(Exception e){
				System.out.println(e);
			}
		}
		else
			System.out.println("Access Time of your File is Correct\n");

		if(String.valueOf(CURRENT_EPOCH_TIME).compareTo(ctime) < 0){       //If current time < creation time
			System.out.println("Oops, Creation Time of your File is Incorrect, i.e. it's in the future\n");
			System.out.println("Fixing it...\n");
			splitter[6] = " ctime:" + CURRENT_EPOCH_TIME;
			String ns = "";
			for(int i=0; i<splitter.length; i++){
				ns = ns + splitter[i] + ",";
			}
			ns = ns.substring(0, ns.lastIndexOf(","));
			try{ 
				PrintWriter w = new PrintWriter(filename);
				w.println(ns);
				System.out.println("File Creation Time is NOW correct\n");
				w.close();
			}
			catch(Exception e){
				System.out.println(e);
			}
		}
		else
			System.out.println("Creation Time of your File is Correct\n");

		if(String.valueOf(CURRENT_EPOCH_TIME).compareTo(mtime) < 0){       //If current time < modified time
			System.out.println("Oops, Last Modification Time of your File is Incorrect, i.e. it's in the future\n");
			System.out.println("Fixing it...\n");
			splitter[7] = " mtime:" + CURRENT_EPOCH_TIME;
			String ns = "";
			for(int i=0; i<splitter.length; i++){
				ns = ns + splitter[i] + ",";
			}
			ns = ns.substring(0, ns.lastIndexOf(","));
			try{ 
				PrintWriter w = new PrintWriter(filename);
				w.println(ns);
				System.out.println("File Modification Time is NOW correct\n");
				w.close();
			}
			catch(Exception e){
				System.out.println(e);
			}
		}
		else
			System.out.println("Modification Time of your File is Correct\n");

		//LinkCount
		String lcount = data.substring(data.indexOf("linkcount:")+10, data.indexOf(",", data.indexOf("linkcount:")));

		//Indirect
		String indirect = data.substring(data.indexOf("indirect:")+9, data.indexOf(" ", data.indexOf("indirect:")));

		//Size
		String size = data.substring(data.indexOf("size:")+5, data.indexOf(",", data.indexOf("size:")));
		double req_blocks = Math.ceil(Double.parseDouble(size) / BLOCK_SIZE);
		int reqblocks = (int)(req_blocks);
		if(Integer.parseInt(indirect) == 0){
			if(Integer.parseInt(size) < 0){
				System.out.println("It's absurd, your file size field says the file size is less than 0 which is impossible!!!");
			}
			if(Integer.parseInt(size) == 0){
				System.out.println("File size is 0!");
			}
			if(Integer.parseInt(size) > BLOCK_SIZE){
				System.out.println("Oops, File requires more than 1 block and indirect should be set to 1, but currently indirect is 0!!!)");
			}
		}
		else{
			if(Integer.parseInt(size) <= BLOCK_SIZE && Integer.parseInt(size)>0 && Integer.parseInt(indirect) == 1){
				System.out.println("Oops, Your File requires only 1 block, but indirect is set to 1 which it should be 0!!!");
			}
		}

		//Location
		String location = data.substring(data.indexOf("location:")+9, data.indexOf("}", data.indexOf("location:")));
		String [] spl = data.split(",");
		String loc = "";
		loc = data.substring(data.indexOf("location:"));
		String temp = file_Reader(path + location);
		String [] arr = temp.split(",");
		if (arr.length > 1 && Integer.parseInt(indirect) == 0){
			System.out.println("Oops, The location pointer is an array of " + arr.length + " pointers and indirect should be 1\n");
			System.out.println("Fixing it...\n");
		    spl[8] = " indirect:1 " + loc;
		    String hello = "";
		    for (int i=0;i<spl.length;i++){
		        hello = hello +spl[i] + ",";
		    }
		    hello = hello.substring(0, hello.lastIndexOf(","));
			try{
			PrintWriter pi = new PrintWriter(filename);
			pi.println(hello);
			System.out.println("Index is NOW set to 1\n");
			pi.close();
		    }
		    catch (Exception e){
		    	System.out.println(e);
		    }
		}
		else if (arr.length == 1 && Integer.parseInt(indirect) == 1){
			System.out.println("Oops, The location pointer have only " + reqblocks + " pointer and indirect should be 0\n");
			System.out.println("Fixing it...\n");
			 spl[8] = " indirect:0 " + loc;
			    String hello = "";
			    for (int i=0;i<spl.length;i++){
			        hello = hello +spl[i] + ",";
			    }
			    hello = hello.substring(0, hello.lastIndexOf(","));
				try{
				PrintWriter pi = new PrintWriter(filename);
				pi.println(hello);
				System.out.println("Index is NOW set to 0\n");
				pi.close();
			    }
			    catch (Exception e){
			    	System.out.println(e);
			    }
		}
		else if (arr.length > 1 && Integer.parseInt(indirect) == 1){
			System.out.println("All is Well, File requires " + reqblocks + " pointers and indirect is 1 accordingly\n");
		}
		else if (arr.length == 1 && Integer.parseInt(indirect) == 0){
			System.out.println("All is Well, File requires " + reqblocks + " pointer and indirect is 0 accordingly\n");
		}
		System.out.println("Array of pointer/pointers which ultimately gives the content of the File: " + location);

		//Read File
		String content = "";
		try{
			FileReader fRead = new FileReader(path+location);
			BufferedReader bRead = new BufferedReader(fRead);
			content = bRead.readLine();
		}
		catch(Exception e){
			System.out.println(e);
		}
		String [] datapointers = content.split(", ");

		for(int i=0;i<datapointers.length;i++){
			System.out.println(datapointers[i]);
		}

		if(Integer.parseInt(size) > datapointers.length * BLOCK_SIZE){
			System.out.println("Oops, Size of your file is greater than alloted size!!!");
		}
		if(Integer.parseInt(size) < datapointers.length-1 * BLOCK_SIZE){
			System.out.println("Oh God!!!, you're wasting space, allocated more space than required by the file!!!");
		}

		System.out.println("\nFile Checker terminated for File with path: " + filename + "\n");
	}

	public void traverse(String filename){
		if (filename.equals(path + ROOT) == false){
			System.out.println("Oops, the argument is not a Path to Root Directory, traversal can't be performed!!!\n");
		}
		else{
			System.out.println("\nTraversal of the File System initiated!!!\n");
			String s = new String();
			s = file_Reader(filename);
			String filesline = s.substring(s.indexOf("filename_to_inode_dict:")+25, s.indexOf("}", s.indexOf("filename_to_inode_dict:")));
			List<String> fileList = new ArrayList<String>();
			List<String> dirList = new ArrayList<String>();

			int loc = 0;
			String dnm, point;
			char type;
			while(loc<= filesline.length()){
				type = filesline.charAt(loc);
				dnm = filesline.substring(loc+2,filesline.indexOf(":",loc + 2));

				if(loc > filesline.lastIndexOf(',')){
					point = filesline.substring(filesline.indexOf(":", loc + 2) + 1, filesline.length());
					loc = filesline.length() + 1;
				}
				else{
					point = filesline.substring(filesline.indexOf(":", loc + 2) + 1, filesline.indexOf(",",loc + 2));
					loc = filesline.indexOf(",",loc + 1) + 2;
				}
				if(type == 'd'){
					dirList.add(point);
				}
				if(type == 'f'){
					fileList.add(point);
				}
			}
			for (String i : dirList){
				if(Integer.parseInt(i)<ROOT)
					System.out.println("Oops, " + path + i + " isn't a Directory\n" + "Directory Checker is terminated");
				else
					directory_Checker(path + i);	
			}
			for (String i : fileList){
				if(Integer.parseInt(i)<=ROOT)
					System.out.println("Oops, FS/fusedata."+ i + " isn't a File\n" + "Directory Checker is terminated");
				else
					file_Checker(path+i);
			}


		}
		super_Block_Checker();
		free_Block_Checker();
		System.out.println("\nTraversal of the File System Complete...\n");
	}

	public static void main(String [] args){
		csefsck a = new csefsck();
		a.traverse(path + ROOT);
		//System.out.println(System.nanoTime());
	}
}
