
import org.apache.hadoop.conf.Configuration;
import org.apache.hadoop.fs.Path;
import org.apache.hadoop.io.FloatWritable;
import org.apache.hadoop.io.IntWritable;
import org.apache.hadoop.io.Text;
import org.apache.hadoop.mapreduce.Job;
import org.apache.hadoop.mapreduce.lib.input.FileInputFormat;
import org.apache.hadoop.mapreduce.lib.output.FileOutputFormat;


public class HateScore{
    @SuppressWarnings("deprecation")
    public static void main(String[] args) throws Exception {
    	
		Configuration conf = new Configuration();
		String custom_delimiter = "~|\n";
		conf.set("textinputformat.record.delimiter", custom_delimiter);
		//conf.set("mapreduce.output.textoutputformat.separator", " "); //output default is tab between key and value
		
		Job job = Job.getInstance(conf, "HateScore");
        job.setJarByClass(HateScore.class);
        FileInputFormat.addInputPath(job, new Path(args[0]));
        FileOutputFormat.setOutputPath(job, new Path(args[1]));
        
        job.setMapperClass(HateScoreMapper.class);
        job.setReducerClass(HateScoreReducer.class);
        
        // map output different from reducer output
        // https://developer.yahoo.com/hadoop/tutorial/module5.html
        job.setMapOutputKeyClass(Text.class);
        job.setMapOutputValueClass(IntWritable.class);
        
        System.exit(job.waitForCompletion(true) ? 0 : 1);
    }
}