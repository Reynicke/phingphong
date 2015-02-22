# phingphong
Misc custom Phing tasks

## Import task definitions
```XML
<import file="phingphong/phingphong.xml" />
```

## Tasks
#### filesmodified
Checks if files were modified in the last x seconds
```XML
<fileset dir="some/dir" includes="**/*" id="files" />
<filesmodified before='60' modified="isModified">
     <fileset refid="files" />
</filesmodified>
```
