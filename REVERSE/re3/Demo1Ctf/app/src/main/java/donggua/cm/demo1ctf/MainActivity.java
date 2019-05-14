package donggua.cm.demo1ctf;

import android.app.Activity;
import android.os.Bundle;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;


public class MainActivity extends Activity {

    private XUtil xUtil=XUtil.getInstance();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        TextView xText=findViewById(R.id.x_text);
        Button xButton=findViewById(R.id.x_button);
        EditText xEditText=findViewById(R.id.x_edit);

        xButton.setOnClickListener((view)->{
            String code = xEditText.getText().toString().trim();
            if (xUtil.check(code)){
                xText.setText("flag{"+code+"}");
                xButton.setText("success");
            }else {
                xText.setText("error");
                xButton.setText(R.string.submit0);
            }
        });
    }
}
