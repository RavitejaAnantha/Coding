import java.io.IOException;
import org.apache.hadoop.mapreduce.Mapper;
import org.apache.hadoop.io.Text;
import org.apache.hadoop.io.IntWritable;
import org.apache.hadoop.io.LongWritable;

public class HateFriendsMapper extends Mapper<LongWritable, Text, Text, IntWritable> {

    private final static IntWritable one = new IntWritable(1);
    
    public void map(LongWritable key, Text value, Context context) throws IOException, InterruptedException {
            
    	// Value will have screen_name <tab> friend_id~|\n 
    	// the ~|\n is the end of each line: either custom delimiter identify it, or string replace it
    	
		String temp = value.toString();
		int ind = temp.indexOf("	") + 1;
		String screen_name = temp.substring(0,temp.indexOf("	")); //user id or screen name
		String friend_id = temp.substring(ind); // screen_name subscribed to this twitter handle or id
		friend_id = friend_id.replace("~|", ""); //clean delimiter
    	context.write(new Text(friend_id), one);

    }
}