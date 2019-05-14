package donggua.cm.demo1ctf;

import org.junit.Test;

import java.util.Base64;
import java.util.HashMap;
import java.util.Map;

import io.jsonwebtoken.Jwt;
import io.jsonwebtoken.Jwts;
import io.jsonwebtoken.SignatureAlgorithm;

import static org.junit.Assert.*;

/**
 * Example local unit test, which will execute on the development machine (host).
 *
 * @see <a href="http://d.android.com/tools/testing">Testing documentation</a>
 */
public class ExampleUnitTest {

    @Test
    public void addition_isCorrect() {
        assertEquals(4, 2 + 2);
    }

    @Test
    public void generatorJwt(){
        Map map=new HashMap();
        //加密字符串
        map.put("value","UwVqoqqGlWXaslKKbbHcbOIqqqTwYYYlelDG");
        String secret_key=Base64.getEncoder().encodeToString("8048xuejienihaobango".getBytes());
        System.out.println(secret_key);
        String token = Jwts.builder().setHeaderParam("typ", "JWT")
                .addClaims(map).signWith(SignatureAlgorithm.HS256, secret_key)
                .compact();
        System.out.println(token);

        Jwt parse = Jwts.parser().setSigningKey(secret_key).parse(token);
        Map<String,String> map1= (Map<String, String>) parse.getBody();
        String value = map1.get("value");
        System.out.println(value);
    }

    @Test
    public void getvule(){
        System.out.println(XUtil.getInstance().getXValue());
    }
}