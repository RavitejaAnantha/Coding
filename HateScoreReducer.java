import java.io.IOException;
import org.apache.hadoop.io.IntWritable;
import org.apache.hadoop.io.FloatWritable;
import org.apache.hadoop.io.Text;
import org.apache.hadoop.mapreduce.Reducer;


public class HateScoreReducer extends Reducer<Text, IntWritable, Text, FloatWritable> {
	
    private final static IntWritable one = new IntWritable(1);
    private final static IntWritable zero = new IntWritable(0);
    
    @Override
    public void reduce(Text key, Iterable<IntWritable> values, Context context) throws IOException, InterruptedException {	
	    // Comments refer to Reddit comments or twitter tweets
    	// Aggregate total comments and offensive comments
    	float totalComments = 0f;
	    float hateComments = 0f;
		for (IntWritable value : values) {
			totalComments += 1f;
			if (value.equals(one)) {
				hateComments += 1f;
			}
		}
		System.out.println("Total comments - " + Float.toString(totalComments) + ", Hate comments - " + Float.toString(hateComments));
        context.write(key, new FloatWritable((float) hateComments/totalComments));
    }
}