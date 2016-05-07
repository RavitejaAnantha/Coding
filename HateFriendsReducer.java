import java.io.IOException;
import org.apache.hadoop.io.IntWritable;
import org.apache.hadoop.io.FloatWritable;
import org.apache.hadoop.io.Text;
import org.apache.hadoop.mapreduce.Reducer;


public class HateFriendsReducer extends Reducer<Text, IntWritable, Text, IntWritable> {
	
    private final static IntWritable one = new IntWritable(1);
    
    @Override
    public void reduce(Text key, Iterable<IntWritable> values, Context context) throws IOException, InterruptedException {
        int sum = 0;
    	for (IntWritable value : values) {
            sum += value.get(); //adding each offensive follower of group
		}
		System.out.println("Group id - " + key + " , Count - " + sum);
        context.write(key, new IntWritable(sum));
    }
}