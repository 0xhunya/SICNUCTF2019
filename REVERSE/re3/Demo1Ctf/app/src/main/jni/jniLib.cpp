#include <donggua_cm_demo1ctf_JNIUtil.h>
#include <string.h>
JNIEXPORT jstring JNICALL Java_donggua_cm_demo1ctf_JNIUtil_en
  (JNIEnv *env, jobject jobjcet, jstring str){
  char *prim = (char*)env->GetStringUTFChars(str, 0);
          char code[100];
          int i,n,len;
          char temp_char,trans_char;
          int temp_num,trans_num;
          len = strlen(prim);
          for (int i = 0; i < len; ++i)
          {
              code[i] = prim[i] + 1;
          }

          for(i = 0;i < len;i++) {
              temp_char = prim[i];                   //Consider about the corresponding number of character
              if (temp_char <= 'z' && temp_char >= 'a')
                  temp_num = temp_char - 'a' + 1;
              else if (temp_char <= 'Z' && temp_char >= 'A')
                  temp_num = temp_char - 'A' + 27;

              trans_num = temp_num*3 % 52;

              if (trans_num > 26 && trans_num <= 52)         //Transform number to character
                  trans_char = 'A' + trans_num - 27;
              else if (trans_num > 0 && trans_num <= 26)
                  trans_char = 'a' + trans_num - 1;

              code[i] = trans_char;
          }
          code[len] = '\0';
      return env->NewStringUTF(code);
  }


